<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\form_complete.php
 * ファイル名 : form_complete.php
 * アクセスURL : http://localhost/DT/shop/form_complete.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\Bootstrap;
use shop\lib\PDODatabase;
use shop\lib\Common;


$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

$twig->addExtension(new \Twig\Extension\DebugExtension());

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);


$template = $twig->loadTemplate('form_complete.html.twig');
$template->display([]);