<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\mypage.php
 * ファイル名 : mypage.php (マイページ表示するプログラム、Controller)
 * アクセスURL : http://localhost/DT/shop/mypage.php
 */ 
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;
use shop\lib\Sale;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$sale = new Sale($db);

// 未ログイン排除
if (!isset($_SESSION['login_id'])) {
    header('location:'. Bootstrap::ENTRY_URL . 'list_guest.php');
    exit(); 
}

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);


// SessionKeyを見て、DBへの登録状態をチェックする
$customer_id = $_SESSION['customer_id'];
$ses->checkSession($customer_id);
 

$sesArr['login_id'] = $_SESSION['login_id'];

// 売上取得
$saleArr = $sale->getSaleData($customer_id);
var_dump($saleArr);

$context = [];
$context['sesArr'] = $sesArr;
$context['saleArr'] = $saleArr;
$template = $twig->loadTemplate('mypage.html.twig');
$template->display($context);



