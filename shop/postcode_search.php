<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\postcode_search.php
 * ファイル名 : postcode_search.php
 */
namespace shop;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shop\lib\PDODatabase;
use shop\Bootstrap;


$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);

if (isset($_GET['zip1']) === true && isset($_GET['zip2']) === true) {
    $zip1 = $_GET['zip1'];
    $zip2 = $_GET['zip2'];
    $arrVal = [];
    $arrVal[] = $zip1 . $zip2;
    $table = 'postcode';
    $where = 'zip = ?';


    $data = $db->selectPostcode($table, $column = '', $where, $arrVal);
   // $query = SELECT pref, city, town FROM postcode WHERE zip = $zip LIMIT 1;
   // $res = $db->select($query);

   // 出力結果がajaxに渡される
    echo ($data !== "" && count($data) !== 0) ? $data[0]['pref'] . $data[0]['city'] . $data[0]['town'] : '';
} else {
    echo "no";
}