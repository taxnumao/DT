<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\list.php
 * ファイル名 : list.php (商品一覧を表示するプログラム、Controller)
 * アクセスURL : http://localhost/DT/shop/list.php
 */ 
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Session;
use shop\lib\Item;
use shop\lib\Review;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$itm = new Item($db);
$rev = new Review($db);

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

// SessionKeyを見て、DBへの登録状態をチェックする
$ses->checkSession();

$sesArr['login_id'] = $_SESSION['login_id'];


// カテゴリーリスト(一覧)を取得
$ctg_id = (isset($_GET['ctg_id']) === true && preg_match('/^[0-9]+$/', $_GET['ctg_id']) === 1) ? $_GET['ctg_id'] : '';
$cateArr = $itm->getCategoryList();

// 検索窓
$text = (isset($_GET['text']) === true) ? $_GET['text'] : '';
if ($text) {
    $dataArr = $itm->getItemSearch($text);
    if (!$dataArr) {
        // $msg = 'false';
        $dataArr = $itm->getItemList($ctg_id);
    }
} else {
    $dataArr = $itm->getItemList($ctg_id);
}

foreach ($dataArr as $key => $value) {
    if ($key % 2 != 0 ) {
        $dataArrOdd[] = $value;
    } else {
        $dataArrEven[] = $value;
    }
}


// 口コミを取得
$reviewArr = $rev->getReviewData();

$context = [];
// $context['msg'] = $msg;
$context['cateArr'] = $cateArr;
$context['dataArrOdd'] = $dataArrOdd;
$context['dataArrEven'] = $dataArrEven;
$context['sesArr'] = $sesArr;
$context['reviewArr'] = $reviewArr;
$template = $twig->loadTemplate('list.html.twig');
$template->display($context);







