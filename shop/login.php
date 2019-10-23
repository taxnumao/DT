<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\login.php
 * ファイル名 : login.php
 * アクセスURL : http://localhost/DT/shop/login.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Common;
use shop\lib\Session;
use shop\lib\Login;

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$common = new Common();
$login = new Login();


$mode = '';
$data = '';
$dataArr = '';
$errArr = '';
$errMsg = '';

if (isset($_POST['login']) === true) {
    $mode = 'login';
}


switch ($mode) {
    case 'login': 

        unset($_POST['login']);

        $dataArr = $_POST;
        $errArr = $common->errorCheckLogin($dataArr);
        $err_check = $common->getErrorFlg();
        $dataArr['pass1'] = md5($dataArr['pass1']);

        
        if ($err_check === false) {

            $template = 'login.html.twig';

        } else {

           $data = $login->login($db, $dataArr);

            // 該当のcustomerのデータを取ってくる

            if ($data) {

                $customer_id = $data[0]['customer_id'];
                $ses = new Session($db);
                $ses->checkSession($customer_id);
                $_SESSION['login_id'] = $_POST['login_id'];
                $_SESSION['customer_id'] = $customer_id;
                //ログイン成功時は商品リストページへ
                header('Location:' . Bootstrap::ENTRY_URL . 'list.php');
                exit();
            } else {
                // ログイン失敗時はログイン画面に戻る
                $errMsg = 'ログインIDとパスワードが一致しません';
                echo '[error message] ログインに失敗しました';

                $template = 'login.html.twig';

                foreach ($dataArr as $key => $value) {
                    $errArr[$key] = '';
                }
            }
        }
        break;
    }

$context = [];
$context['dataArr'] = $dataArr;
$context['errArr']= $errArr;
$context['errMsg'] = $errMsg;
$context['data'] = $data;
$template = $twig->loadTemplate('login.html.twig');
$template->display($context);


