<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\sale_complete.php
 * ファイル名 : sale_complete.php (カート処理終了画面 controller)
 * アクセスURL : http://localhost/DT/shop/sale_complete.php
 */ 
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;


$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);

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


$context = [];
$template = $twig->loadTemplate('sale_complete.html.twig');
$template->display($context);


