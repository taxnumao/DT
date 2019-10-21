<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\Bootstrap.class.php
 * ファイル名 : Bootstrap.class.php (設定に関するプログラム)
 */
namespace shop;

date_default_timezone_set('Asia/Tokyo');

require_once dirname(__FILE__) . './../vendor/autoload.php';

class Bootstrap
{
    const DB_HOST = 'localhost';

    const DB_NAME = 'shop_db';

    const DB_USER = 'shop_user';

    const DB_PASS = 'shop_pass';

    const DB_TYPE = 'mysql';

    //const APP_DIR = 'c:/xampp/htdocs/DT/';
    const APP_DIR = '/Applications/XAMPP/xamppfiles/htdocs/DT/';

    const TEMPLATE_DIR = self::APP_DIR . 'templates/shop/';

    //const CACHE_DIR = false;
    const CACHE_DIR = self::APP_DIR . 'templates_c/shop/';

    const APP_URL = 'http://localhost/DT/';

    const ENTRY_URL = self::APP_URL . 'shop/';

    public static function loadClass($class) {
        $path = str_replace('\\', '/', self::APP_DIR . $class . '.class.php');
        require_once $path;
    }
}
// これを実行しないとオートローダーとして動かない
spl_autoload_register([
    'shop\Bootstrap',
    'loadClass'
]);