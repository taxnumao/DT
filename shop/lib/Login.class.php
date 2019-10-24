<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Login.class.php
 * ファイル名 : Login.class.php(ログインのクラスファイル、Model)
 */
namespace shop\lib;

class Login {

    public $db = null;

    // ログイン
    public function login($db, $dataArr) {

        $table = 'customer';                        //LEFT JOIN sale s ON s.customer_id = c.customer_id
        $where = 'login_id = ? AND pass1 = ? AND delete_flg = ?';
        $insData = [];
        $dataArr['delete_flg'] = 0;
        $insData[] = $dataArr['login_id'];
        $insData[] = $dataArr['pass1'];
        $insData[] = $dataArr['delete_flg'];
        $data = '';

        $data = $db->select($table, $column = '', $where, $insData);
        
        return $data;
    }
}

