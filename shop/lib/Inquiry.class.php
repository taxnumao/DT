<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Review.class.php
 * ファイル名 : Review.class.php (カートに関するプログラムのクラスファイル、Model)
 */ 
namespace shop\lib;

class Inquiry
{

    private $db = null;
    private $strOrder = '';

    public function __construct($db = null)
    {
        $this->db = $db;
    }

    // 問い合わせ登録
    public function insInquiryData($dataArr)
    {
        unset($dataArr['complete']);
        
        $table = 'inquiry';

        return $this->db->insert($table, $dataArr);
    }
}