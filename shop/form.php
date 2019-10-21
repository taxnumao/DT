<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\form.php
 * ファイル名 : confirm.php
 * アクセスURL : http://localhost/DT/shop/form.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\master\initMaster;
use shop\Bootstrap;

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

$dataArr = [
    'family_name' => '',
    'first_name' => '',
    'family_name_kana' => '',
    'first_name_kana' => '',
    'sex' => '',
    'email' => '',
    'contents' => ''

];

// エラーメッセージの定義、初期
$errArr = [];
foreach ($dataArr as $key => $value) {
    $errArr[$key] = '';
}

$sexArr = initMaster::getSex();

$context = [];
$context['sexArr'] = $sexArr;
$context['errArr'] = $errArr;

$template = $twig->loadTemplate('form.html.twig');
$template->display($context);