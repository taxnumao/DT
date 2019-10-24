<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\staff_complete.php
 * ファイル名 : staff_complete.php
 * アクセスURL : http://localhost/DT/shop/staff_complete.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
// use shop\lib\Session;


$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);


$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
// $ses = new Session($db);

// if (isset($staff_no) === '') {
//     exit(); 
// }

// $staff_id = $_SESSION['staff_id'];
// $ses->checkSession($staff_id);

$template = $twig->loadTemplate('staff_complete.html.twig');
$template->display([]);