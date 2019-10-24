<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Customer.class.php
 * ファイル名 : Customer.class.php(顧客に関するプログラムのクラスファイル、Model)
 */
namespace shop\lib;

class Customer {
    
    public $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    // 顧客登録
    public function registCustomer($dataArr) {

        unset($dataArr['complete']);
        unset($dataArr['pass2']);

        $dataArr['pass1'] = md5($dataArr['pass1']);
        $dataArr['regist_date'] = date("Y/m/d H:i:s");

        $table = 'customer';
        
        $res = '';
        $res = $this->db->insert($table, $dataArr);

        return $res;
    }

    // 顧客データ(mail用)の取得
    public function getCustomer($customer_id) {
        $table = 'customer';
        $col = 'family_name, email';
        $where = 'customer_id = ?';
        $arrVal = [$customer_id];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return $res;
    }

    // 顧客データ(編集用)の取得
    public function getCustomer2($customer_id) {
        $table = 'customer';
        $where = 'customer_id = ?';
        $arrVal = [$customer_id];

        $res = $this->db->select($table, $col = '', $where, $arrVal);

        return $res;
    }

    // 顧客データの削除
    public function deleteCustomer($customer_id) {
        $table = 'customer';
        $where = 'customer_id = ?';
        $insData = ['delete_date' => date("Y/m/d H:i:s"), 'delete_flg' => 1];
        $arrWhereVal = [$customer_id];

        $res = $this->db->update($table, $insData, $where, $arrWhereVal);

        return $res;
    }

}