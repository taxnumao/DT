<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\logout.php
 * ファイル名 : logout.php
 * アクセスURL : http://localhost/DT/shop/logout.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);

if (!isset($_SESSION['login_id'])) {
    header('location:'. Bootstrap::ENTRY_URL . 'login.php');
    exit(); 
}

$customer_id = $_SESSION['customer_id'];
$ses->checkSession($customer_id);
$sesArr['login_id'] = $_SESSION['login_id'];

$_SESSION = array();
if (isset($_COOKIE[session_name()]) === true) {
    setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();



$context = [];
$context['sesArr'] = $sesArr; 
$template = $twig->loadTemplate('logout.html.twig');
$template->display($context);