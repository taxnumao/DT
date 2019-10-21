<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\end.php
 * ファイル名 : end.php
 * アクセスURL : http://localhost/DT/shop/end.php
 */
 namespace shop;

 require_once dirname(__FILE__) . '/Bootstrap.class.php';


 use shop\lib\PDODatabase;
 use shop\Bootstrap;
 
 // テンプレート指定
 $loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
 $twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
 ]);


$context = [];
$template = $twig->loadTemplate('end.html.twig');
$template->display($context);


