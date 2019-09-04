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

    /**
     * @param        $message
     * @param        $createdAt
     *
     * @return string|void
     */
    public function parseFptShopSms($message, $createdAt)
    {
        //'(FPTShop) Vi Momo 01263998413da nap so tien 500,000 d.Tang KH 20.000d 09X2X7NBCJ726 mua Phu kien tu 50.000d hoac Sim-Phan mem tu 80.000d HSD 10/09'

        $regex = '/^\(FPTShop\) Vi Momo ([0-9]+)da nap so tien ([0-9,]+) d./';
        preg_match($regex, $message, $matches);
        if (!$matches || count($matches) != 3) {
            return null;
        }
        $sdt = $matches[1];
        $amount = $matches[2];
        $alert = "[MoMo] Nhận được số tiền `{$amount}đ` từ `{$sdt}` (FPTShop) vào lúc {$createdAt}";

        return $alert;
    }

    public function isSkippedMessage($message)
    {
        // check MoMo cashout
        if (strpos($message, '.MOMO') !== false && strpos($message, '.CashOut') !== false) {
            return true;
        }

        // check NapTheNhanh cashout
        if (strpos($message, '.ntn') !== false) {
            return true;
        }

        return false;
    }
}
