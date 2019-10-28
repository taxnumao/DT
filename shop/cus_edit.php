<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\cus_edit.php
 * ファイル名 : cus_edit.php
 * アクセスURL : http://localhost/DT/shop/cus_edit.php
 */
 namespace shop;

 require_once dirname(__FILE__) . '/Bootstrap.class.php';

 use shop\master\initMaster;
 use shop\lib\PDODatabase;
 use shop\Bootstrap;
 use shop\lib\Session;
 use shop\lib\Customer;

 $db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
 $ses = new Session($db);
 $cus = new Customer($db);

 // 未ログイン排除
if (!isset($_SESSION['login_id'])) {
    header('Location:' . Bootstrap::ENTRY_URL . 'login.php');
    exit();
}

 // テンプレート指定
 $loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
 $twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
 ]);

// sessionチェック
$ses->checkSession();
$sesArr['login_id'] = $_SESSION['login_id'];
$customer_id = $_SESSION['customer_id'];

 
// 顧客データを設定
$cusArr = $cus->getCustomer2($customer_id);
$dataArr = $cusArr[0];

// エラーメッセージの定義、初期
$errArr = [];
foreach ($dataArr as $key => $value) {
    $errArr[$key] = '';
}

list($yearArr,$monthArr,$dayArr) = initMaster::getDate();
$sexArr = initMaster::getSex();

$context = [];
$context['yearArr'] = $yearArr;
$context['monthArr'] = $monthArr;
$context['dayArr'] = $dayArr;
$context['sexArr'] = $sexArr;
$context['dataArr'] = $dataArr;
$context['errArr'] = $errArr;
$context['sesArr'] = $sesArr;

$template = $twig->loadTemplate('cus_edit.html.twig');
$template->display($context);


