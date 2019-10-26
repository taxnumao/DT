<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Staff.class.php
 * ファイル名 : Staff.class.php(スタッフに関するプログラムのクラスファイル、Model)
 */
namespace shop\lib;

class Staff {
    
    public $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    // スタッフ登録
    public function registStaff($dataArr) {

        unset($dataArr['complete']);
        unset($dataArr['pass2']);
    
        $dataArr['pass1'] = md5($dataArr['pass1']);
        $dataArr['regist_date'] = date("Y/m/d H:i:s");
        $dataArr['traffic'] = implode('_', $dataArr['traffic']);
    
        $table = 'staff';
        
        $res = '';
        $res = $this->db->insert($table, $dataArr);

        return $res;

    }

    // スタッフ情報取得(一覧用)
    public function getStaff() {

        $table = 'staff';
        $where = 'delete_flg = ?';
        $arrVal = [0];
        
        return $this->db->select($table, $column = '', $where, $arrVal);

    }

}