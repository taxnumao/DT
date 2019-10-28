<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\review_omplete.php
 * ファイル名 : review_complete.php
 * アクセスURL : http://localhost/DT/shop/review_complete.php
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

$ses->checkSession();
$sesArr['login_id'] = $_SESSION['login_id'];


$context = [];
$context['sesArr'] = $sesArr;
$template = $twig->loadTemplate('review_complete.html.twig');
$template->display($context);