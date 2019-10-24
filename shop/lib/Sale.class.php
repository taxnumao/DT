<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Sale.class.php
 * ファイル名 : Sale.class.php (売上に関するプログラムのクラスファイル、Model)
 */ 
namespace shop\lib;

class Sale
{

    private $db = null;

    public function __construct($db = null)
    {
        $this->db = $db;
    }

    // 売上情報を取得
    public function getSaleData($customer_id)
    {
        $table = ' sale_detail d LEFT JOIN sale s ON d.sale_no = s.sale_no ';
        $where = ' s.customer_id = ? ';
        $arrVal = [$customer_id];

        return $this->db->select($table, $column = '', $where, $arrVal);
    }

}