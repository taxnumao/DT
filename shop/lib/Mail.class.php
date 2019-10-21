<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Mail.class.php
 * ファイル名 : Mail.class.php (メール関係のクラスファイル、Model)
 */ 
namespace shop\lib;

class Mail
{
    public function __construct()
    {
    }

    public function sendMail($email, $header, $sumPrice, $name, $dataArr)
    {
        $title = 'ご注文ありがとうございます。【きぬ太商店】';
        $honbun = $this->getMailHonbun($sumPrice, $name, $dataArr);
        $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
        md_language('Japanese');
        md_internal_encoding('UTF-8');
        md_send_mail($email, $title, $honbun, $header);
        // $email:送信相手のmail, $title:本文のタイトル, $honbun:メール本文, $header:送信元メールアドレス
    }

    public function receiveMail($email, $header, $sumPrice, $name, $dataArr)
    {
        $title = '店舗注文確認用【きぬ太商店】';
        $honbun = $this->getMailHonbun($sumPrice, $name, $dataArr);
        $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
        md_language('Japanese');
        md_internal_encoding('UTF-8');
        md_send_mail($email, $title, $honbun, $header);
        // $email:送信相手のmail, $title:本文のタイトル, $honbun:メール本文, $header:送信元メールアドレス
        // 送る人と受け取る人を逆にする
    }

    public function getMailHonbun($sumPrice, $name, $dataArr)
    {
        $honbun = '';
        $honbun .= $name . "様 \n\n ご注文ありがとうございます。\n";
        $honbun .= " \n ";
        $honbun .= "ご注文商品 \n";
        $honbun .= "------------------------------------ \n";

        for ($i = 0; $i < count($dataArr); $i ++) {
            $honbun .= $dataArr[$i]['item_name'];
            $honbun .= $dataArr[$i]['price'] . "\n";
        }
        $honbun .= "------------------------------------- \n";
        $honbun .= "支払い金額:";
        $honbun .= $sumPrice . "円";

        $honbun .= "------------------------------------- \n";
        $honbun .= "\n";
        $honbun .= "代金は以下の口座にお支払い願います \n";
        $honbun .= "口座情報 \n";
        $honbun .= "きぬ太商店 \n";
        $honbun .= "000-0000-0000\n";

        return $honbun;

    }

}