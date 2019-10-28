<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\cus_edit.php
 * ファイル名 : cus_edit.php
 * アクセスURL : http://localhost/DT/shop/cus_edit.php
 */
 namespace shop;

 require_once dirname(__FILE__) . '/Bootstrap.class.php';


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

$dataArr['login_id'] = $_SESSION['login_id'];

// 退会処理
$customer_id = $_SESSION['customer_id'];
if (isset($_POST['yes'])) {
    
    $res = $cus->deleteCustomer($customer_id);
    
    if ($res) {

        // ログアウト処理
        $_SESSION = array();
        if (isset($_COOKIE[session_name()]) === true) {
            setcookie(session_name(),'',time()-42000,'/');
        }
        session_destroy();

        header('Location:' . Bootstrap::ENTRY_URL . 'end.php');
        exit();

    } else {

        echo '退会の処理が出来ませんでした。<br>';
        echo 'お手数ですが、お問い合わせ願います。';
        
    }
}

$context = [];
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('cus_delete.html.twig');
$template->display($context);



