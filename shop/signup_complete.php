<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\signup_complete.php
 * ファイル名 : signup_complete.php
 * アクセスURL : http://localhost/DT/shop/signup_complete.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;


$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);


$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);

if (isset($customer_no) === '') {
    header('location:'. Bootstrap::ENTRY_URL . 'list_guest.php');
    exit(); 
}


$ses->checkSession();
$sesArr['login_id'] = $_SESSION['login_id'];


$context = [];
$context['sesArr'] = $sesArr;
$template = $twig->loadTemplate('signup_complete.html.twig');
$template->display($context);