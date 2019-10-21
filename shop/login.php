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

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$common = new Common();


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

            $table = 'customer';
            $where = 'login_id = ? AND pass1 = ? AND delete_flg = ?';
            $insData = [];
            $dataArr['delete_flg'] = 0;
            $insData[] = $dataArr['login_id'];
            $insData[] = $dataArr['pass1'];
            $insData[] = $dataArr['delete_flg'];
            $data = '';

            $data = $db->select($table, $column = '', $where, $insData);

            // 該当のcustomerのデータを取ってくる
            // customer_idが欲しい
            // $data = array(1) { [0]=> array(23) { ["customer_id"]=> string(1) "1" ["family_name"]=> string(1) "a" ["first_name"]=> string(1) "a" ["family_name_kana"]=> string(1) "a" ["first_name_kana"]=> string(1) "a" ["sex"]=> string(1) "1" ["login_id"]=> string(1) "a" ["pass1"]=> string(32) "0cc175b9c0f1b6a831c399e269772661" ["year"]=> string(4) "1900" ["month"]=> string(2) "01" ["day"]=> string(2) "01" ["zip1"]=> string(3) "111" ["zip2"]=> string(4) "1111" ["address"]=> string(2) "11" ["email"]=> string(8) "11@11.11" ["tel1"]=> string(3) "111" ["tel2"]=> string(3) "111" ["tel3"]=> string(3) "111" ["contents"]=> string(1) "a" ["regist_date"]=> string(19) "2019-10-10 02:58:09" ["update_date"]=> NULL ["delete_date"]=> NULL ["delete_flg"]=> string(1) "0" } }
            // $data は多次元連想配列

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


