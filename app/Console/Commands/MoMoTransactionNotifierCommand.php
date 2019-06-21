<?php

namespace App\Console\Commands;

use App\Services\DiscordWebHookClient;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Webklex\IMAP\Message;

class MoMoTransactionNotifierCommand extends Command
{
    /**
     * @var \App\Services\DiscordWebHookClient
     */
    protected $discord;

    /**
     * @var \Webklex\IMAP\Client
     */
    protected $imap;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier:momo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read mailbox to notify MoMo transaction';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->discord = new DiscordWebHookClient(env('DISCORD_ZING_WEBHOOK_URL'));
        $this->imap = \ImapClient::account('momo_mailbox');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Webklex\IMAP\Exceptions\ConnectionFailedException
     * @throws \Webklex\IMAP\Exceptions\GetMessagesFailedException
     * @throws \Webklex\IMAP\Exceptions\InvalidWhereQueryCriteriaException
     * @throws \Webklex\IMAP\Exceptions\MessageSearchValidationException
     */
    public function handle()
    {
        try {
            $this->imap->connect();
            $this->output->title("Checking for new MoMo transactions - " . date('Y-m-d H:i:s'));
            $inbox = $this->imap->getFolder('INBOX');
        } catch (ConnectionFailedException $e) {
            $this->output->error("Cannot connect to mailbox. Reason: " . json_encode($this->imap->getErrors()));
            exit();
        }

        $yesterday = date( "d M Y", strtotime("-1 day"));
        $emails = $inbox->query()->whereText('Bạn vừa nhận được tiền')->whereSince($yesterday)->unseen()->get();
        if ($total = count($emails)) {
            $this->output->text("Going to process {$total} transactions");
        }
        /** @var \Webklex\IMAP\Message $email */
        $processed = 0;
        foreach ($emails as $email) {
            $this->output->text("Processing email {$email->getUid()}");
            file_put_contents($this->getStoragePath($email->getUid() . ".html"), $email->getHTMLBody());
            $this->markAsRead($email);
            $this->alertDiscord($email);
            $processed++;
        }
        $this->output->text("Processed {$processed} items");
        $this->output->success("Process checking MoMo transaction ended - " . date('Y-m-d H:i:s'));
        $this->imap->disconnect();
    }

    private function getStoragePath($path)
    {
        return storage_path("app/public/momo/{$path}");
    }

    public function getReviewUrl(Message $email)
    {
        return url("storage/momo/{$email->getUid()}.html");
    }

    private function alertDiscord(Message $email)
    {
        $message = $this->parseAlertMessage($email->getHTMLBody(), $this->getReviewUrl($email));
        if ($message) {
            $this->discord->send($message);
        }
    }

    private function markAsRead(Message $email)
    {
        $email->setFlag("\\Seen \\Flagged");
    }

    private function parseAlertMessage($emailBody, $linkReview)
    {
        $crawler = new Crawler($emailBody);
        $senderPhoneNode = $crawler->filterXPath("(//*[contains(text(),'Số điện thoại người gửi')])/../..//td[last()]/span");
        if (!$senderPhoneNode->text()) {
            return;
        }
        $amountNode = $crawler->filterXPath("//*[contains(text(),'0đ')]");
        $senderNode = $crawler->filterXPath("(//*[contains(text(),'Người gửi')])/../..//td[last()]/span");
        $noteNode = $crawler->filterXPath("(//*[contains(text(),'Tin nhắn')])/../..//td[last()]/span");
        $timeNode = $crawler->filterXPath("(//*[contains(text(),'Thời gian')])/../..//td[last()]/span");

        $alert = sprintf(
            "[MoMo] Nhận được số tiền `%s` từ `%s` vào lúc %s.",
            $amountNode->text(),
            $senderNode->text(),
            $timeNode->text()
        );
        if ($note = $noteNode->text()) {
            $alert .= " Nội dung: `{$note}`.";
        }
        $alert .= " $linkReview";

        return $alert;
    }
}
