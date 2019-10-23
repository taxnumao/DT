<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\review_regist.php
 * ファイル名 : review_reigst.php (口コミ一覧を表示)
 * アクセスURL : http://localhost/DT/shop/review_regist.php
 */ 
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\master\initMaster;
use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);


// 買ってないひと
if (!isset($_SESSION['sale'])) {
    header('Location:' . Bootstrap::ENTRY_URL . 'review_list.php');
    exit();
}

// twig設定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

$dataArr = [
    'customer_id' => '',
    'nickname' => '',
    'score' => '',
    'entry' => '',
    'contents' => '',
    'regist_date' => ''
];

// エラーメッセージの定義、初期
$errArr = [];
foreach ($dataArr as $key => $value) {
    $errArr[$key] = '';
}

// セッションに、セッションIDを設定する
$customer_id = $_SESSION['customer_id'];
$ses->checkSession($customer_id);

$scoreArr = initMaster::getScore();
$entryArr = initMaster::getEntry();

$context = [];
$context['scoreArr'] = $scoreArr;
$context['entryArr'] = $entryArr;
$context['dataArr'] = $dataArr;
$context['errArr'] = $errArr;
$template = $twig->loadTemplate('review_regist.html.twig');
$template->display($context);
