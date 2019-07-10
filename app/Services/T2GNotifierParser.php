<?php

namespace App\Services;

/**
 * Class T2GNotifierParser
 *
 * @package \App\Services
 */
class T2GNotifierParser
{
    /**
     * @param        $message
     * @param        $createdAt
     *
     * @return string|void
     */
    public function parseDongABankSms($message, $createdAt)
    {
        //DongA Bank thong bao: TK 0110666501 da thay doi: +200,000 VND. Nop tien mat(NGUYEN VAN LOI NOP TM-LONG NHAN 11). So du hien tai la:...
        $checkReceivedMoney = strpos($message, 'da thay doi: +');
        if($checkReceivedMoney === false) {
            return;
        }
        $beginOfAmount = $checkReceivedMoney + 14;
        $endOfAmount = strpos(substr($message, $beginOfAmount), 'VND');
        $amount = trim(substr($message, $beginOfAmount, $endOfAmount));
        $note = trim(substr($message, $beginOfAmount + $endOfAmount + 4));
        $note = trim(substr($note, 0, strpos($note, "So du hien tai")));
        $alert = "[Đông Á Bank] Nhận được số tiền `{$amount}` vào lúc `{$createdAt}`. Nội dung: `{$note}`";

        return $alert;
    }

    /**
     * @param        $stkVCB
     * @param        $message
     * @param        $createdAt
     *
     * @return string|void
     */
    public function parseVietcomBankSms($stkVCB, $message, $createdAt)
    {
        //SD TK 0071001400512 +200,000VND luc 19-06-2019 20:50:40. SD 83,157,241VND. Ref IBVCB.1906190052065001.dangthanhhai
        $checkReceivedMoney = strpos($message, "TK {$stkVCB} +");
        if($checkReceivedMoney === false) {
            return;
        }
        $beginOfAmount = $checkReceivedMoney + 18;
        $endOfAmount = strpos(substr($message, $beginOfAmount), 'VND');
        $amount = trim(substr($message, $beginOfAmount, $endOfAmount));
        $note = trim(substr($message, strpos($message, '. Ref') + 6));
        $alert = "[Vietcombank] Nhận được số tiền `{$amount}` vào lúc `{$createdAt}`. Nội dung: `{$note}`";

        return $alert;
    }
}
