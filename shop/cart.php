<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\cart.php
 * ファイル名 : cart.php (カートページの処理を制御するcontroller)
 * アクセスURL : http://localhost/DT/shop/cart.php
 */ 
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;
use shop\lib\Cart;
use shop\master\initMaster;

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
// セッションに、セッションIDを設定する
$ses->checkSession($customer_id);
$customer_no = $_SESSION['customer_no'];   //sessionCheck();でセットしてる

// item_idを取得する
$item_id = (isset($_GET['item_id']) === true && preg_match('/^\d+$/', $_GET['item_id']) === 1) ? $_GET['item_id'] : ''; //登録用

// item_idが設定されていれば、ショッピングカートに登録する
if ($item_id !== '') {
    $res = $cart->insCartData($customer_no, $item_id);
    // 登録に失敗した場合、エラーページを表示する
    if ($res === false) {
        echo "商品購入に失敗しました。";
        exit();
    }
}

// 数量の変更
if (isset($_POST['num']) === true) {
   
    $crt_id = $_POST['crt_id'];
    $num = $_POST['num'];
    $res = $cart->changeNum($crt_id, $num);

    if ($res === false) {
        echo "変更に失敗しました。";
        exit();
    }
}

// 削除
if (isset($_POST['delete']) === true) {

    $crt_id = $_POST['crt_id'];
    $res = $cart->delCartData($crt_id);
    
    if ($res === false) {
        echo "商品削除に失敗しました。";
        exit();
    }
}

// カート情報を取得する
$dataArr = $cart->getCartData($customer_id);

// アイテム数と合計金額を取得する。listは配列をそれぞれの変数に分ける
// $cartSumAndNumData = $cart->getItemAndSumPrice($customer_no);
list($sumNum, $sumPrice) = $cart->getItemAndSumPrice($customer_id);

$numArr = initMaster::getNum();

$context = [];
$context['numArr'] = $numArr;
$context['sumNum'] = $sumNum;
$context['sumPrice'] = $sumPrice;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('cart.html.twig');
$template->display($context);

var_dump($dataArr);