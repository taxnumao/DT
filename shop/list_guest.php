<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\list_guest.php
 * ファイル名 : list_guest.php (商品一覧を表示するプログラム、Controller)
 * アクセスURL : http://localhost/DT/shop/list_guest.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Item;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$itm = new Item($db);

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$ctg_id = (isset($_GET['ctg_id']) === true && preg_match('/^[0-9]+$/', $_GET['ctg_id']) === 1) ? $_GET['ctg_id'] : '';

// カテゴリーリスト(一覧)を取得する
$cateArr = $itm->getCategoryList();
// 商品リストを取得する
$dataArr = $itm->getItemList($ctg_id);
$context = [];
$context['cateArr'] = $cateArr;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('list_guest.html.twig');
$template->display($context);