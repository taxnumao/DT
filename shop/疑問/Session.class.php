<?php

class Session
{
    public $session_key = '';
    public $db = NULL;



    public function __construct($db)
    {
        // セッションをスタートする
        session_start();
        // セッションIDを取得する
        $this->session_key = session_id();
        // DBの登録
        $this->db = $db;
    }




    public function checkSession($customer_id)
    {
        // セッションIDのチェック

        $customer_no = $this->selectSession(); //customer_noを探しに行った

        //---------------------selcctSession()-------------------------
        $table = ' session ';
        $col = ' customer_no ';                                                 //session
        $where = ' session_key = ?';                                            //  customer_no
        $arrVal = [$this->session_key];                                         //  session_key
                                                                                //  customer_id
        $res = $this->db->select($table, $col, $where, $arrVal);

        // セッションIDあれば customer_no  (1)     なければ false  (2)
        return (count($res) !== 0) ? $res[0]['customer_no'] : false; 

        //---------------------selcctSession()--------------------------

        
        // (1) セッションIDがある(過去にショッピングカートに来たことがある)     customer_no返る                 ブラウザから離れても？ セッションID変わるやん？
        
        if ($customer_no !== false) {
            $_SESSION['customer_no'] = $customer_no;


        } else {

        // (2) セッションIDがない(初めてこのサイトに来ている)                 falseが返る

            // セッションテーブルに登録
            $res = $this->insertSession($customer_id));

        //--------------------insertSession($customer_id)---------------------------------------------
        $table = ' session ';
        $insData = ['session_key ' => $this->session_key, 'customer_id' => $customer_id];
        $res = $this->db->insert($table, $insData);
        return $res;
        //--------------------insertSession($customer_id)---------------------------------------------



               //成功  $_SESSION['customer_no'] に直前にインサートした主キーを登録
            if ($res === true) {
                $_SESSION['customer_no'] = $this->db->getLastId();
            } else {
               //失敗  $_SESSION['customer_no'] は空
                $_SESSION['customer_no'] = '';
            }
        }
    }
}
