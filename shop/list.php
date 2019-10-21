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

// 未ログイン排除
if (!isset($_SESSION['login_id'])) {
    header('location:'. Bootstrap::ENTRY_URL . 'list_guest.php');
    exit(); 
}

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$customer_id = $_SESSION['customer_id'];
// SessionKeyを見て、DBへの登録状態をチェックする
$ses->checkSession($customer_id);
$customer_no = $_SESSION['customer_no']; 

$sesArr['login_id'] = $_SESSION['login_id'];

$ctg_id = (isset($_GET['ctg_id']) === true && preg_match('/^[0-9]+$/', $_GET['ctg_id']) === 1) ? $_GET['ctg_id'] : '';


// カテゴリーリスト(一覧)を取得
$cateArr = $itm->getCategoryList();
// 商品リストを取得
$dataArr = $itm->getItemList($ctg_id);
// 口コミを取得
$reviewArr = $rev->getReviewData();

// 検索窓の機能 あとでやる
// $data = [];
// if (isset($_POST['search'])) {
//     unset($_POST['search']);
//     $search = $_POST['item_name'];
//     $table = 'item';
//     $where = 'item_name = ?';
//     $arrVal = [];
//     $arrVal[] = "LIKE %" . $search . "%";

//     $data = $db->select($table, $column = '', $where, $arrVal);
//     //sql = SELECT * FROM item  WHERE item_name LIKE '%$search%';
    
//     if ($data) {
//         echo 'ok';
//     } else {
//         echo 'no';
//     }
    
// }


$context = [];
// $context['data'] = $data;
// テスト↑
$context['cateArr'] = $cateArr;
$context['dataArr'] = $dataArr;
$context['sesArr'] = $sesArr;
$context['reviewArr'] = $reviewArr;
$template = $twig->loadTemplate('list.html.twig');
$template->display($context);

