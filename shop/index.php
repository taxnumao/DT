<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\index.php
 * ファイル名 : index.php
 * アクセスURL : http://localhost/DT/shop/index.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Common;
use shop\lib\Session;

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);


$template = $twig->loadTemplate('index.html.twig');
$template->display($context);