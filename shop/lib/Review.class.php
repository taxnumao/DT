<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Review.class.php
 * ファイル名 : Review.class.php (カートに関するプログラムのクラスファイル、Model)
 */ 
namespace shop\lib;

class Review
{

    private $db = null;
    private $strOrder = '';

    public function __construct($db = null)
    {
        $this->db = $db;
    }

    // 口コミ登録
    public function insReviewData($insData, $customer_id)
    {

        $insData['customer_id'] = $customer_id;
        $insData['regist_date'] = date("Y/m/d H:i:s");

        $table = 'review';
        
        return $this->db->insert($table, $insData);
    }

    // 口コミの情報を取得する
    public function getReviewData()
    {
        $table = 'review';
        $strOrder = 'review_id DESC';
        $this->db->setOrder($strOrder);

        $res = $this->db->select($table);
        $strOrder = '';

        return $res;
    }
}