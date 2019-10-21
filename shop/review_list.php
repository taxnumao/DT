<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\review_list.php
 * ファイル名 : review_list.php (口コミ一覧を表示)
 * アクセスURL : http://localhost/DT/shop/review_list.php
 */ 
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;
use shop\lib\Review;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$rev = new Review($db);

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

// セッションに、セッションIDを設定する
$customer_id = $_SESSION['customer_id'];
$ses->checkSession($customer_id);

$dataArr = $rev->getReviewData();

$context = [];
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('review_list.html.twig');
$template->display($context);




