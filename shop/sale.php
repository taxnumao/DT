<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\sale.php
 * ファイル名 : sale.php (カート処理 controller)
 * アクセスURL : http://localhost/DT/shop/sale.php
 */ 
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;
use shop\lib\Cart;
use shop\lib\Customer;
use shop\lib\Mail;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$cart = new Cart($db);

// 未ログイン排除
if (!isset($_SESSION['login_id'])) {
    header('Location:' . Bootstrap::ENTRY_URL . 'login.php');
    exit();
}



$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

$customer_id = $_SESSION['customer_id'];
$ses->checkSession($customer_id);


// カート情報の取得
$dataArr = $cart->getCartData($customer_id);

// 商品0の場合飛ばす
if (count($dataArr) ===0 ) {
    header('Location:' . Bootstrap::ENTRY_URL . 'list.php');
    exit();
}



// アイテム数と合計金額取得 (listは配列をそれぞれの変数に分ける)
list($sumNum, $sumPrice) = $cart->getItemAndSumPrice($customer_id);
  
// 注文確定処理
if (isset($_POST['decision'])) {

    // sale , sale_detailを登録する
    $res = $db->orderItem($customer_id, $dataArr);  

    if ($res) {

        // 顧客情報の取得
        $cus = new Customer($db);
        $customerArr = $cus->getCustomer($customer_id);

        // mailの送信
        $name = $customerArr[0]['family_name'];
        $header = $customerArr[0]['email'];
        $email = "tanukiti@yahoo.co.jp";

        $mail = new Mail();
        $mail->sendMail($email, $header, $sumPrice, $name, $dataArr);

        $header = "tanukiti@yahoo.co.jp";
        $email = $customerArr['email'];
        $mail->receiveMail($email, $header, $sumPrice, $name, $dataArr);

        // 登録マル 完了画面へ
        header('Location:' . Bootstrap::ENTRY_URL . 'sale_complete.php');
        exit();

    } else {

        // 登録バツ、カートに戻す
        header('Location:' . Bootstrap::ENTRY_URL . 'cart.php');
        exit();
    }
}


$context = [];
$context['sumNum'] = $sumNum;
$context['sumPrice'] = $sumPrice;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('sale.html.twig');
$template->display($context);

// var_dump($res);



