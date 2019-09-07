<?php

namespace App\Console\Commands;

use App\Models\Payment;
use Illuminate\Console\Command;

class UpdatePaymentStatusCodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:update_status_code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update new column `status_code` for table `payments`';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $perPage = 1000;
        $offset = 0;
        $processed = 0;
        $this->output->text("Updating payments status code");
        while (1) {
            $payments = Payment::offset($offset)
                ->limit($perPage)
                ->orderBy('id', 'asc')
                ->get();
            if (!$payments->count()) {
                break;
            }
            $this->output->text("Processing with offset {$offset}");
            foreach ($payments as $payment) {
                $payment->status_code = Payment::getPaymentStatus($payment);
                $payment->save();
                $processed++;
            }
            $offset += $perPage;
        }

        $this->output->success("Processed {$processed} payments");
    }
}
