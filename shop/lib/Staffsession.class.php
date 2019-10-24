<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Staffsession.class.php
 * ファイル名 : Staffsession.class.php (セッション関係のクラスファイル、Model)
 */ 
namespace shop\lib;

class Staffsession
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

    public function checkSession($staff_id)
    {
        // セッションIDのチェック
        $staff_no = $this->selectSession();
        // セッションIDがある(過去にショッピングカートに来たことがある)
        if ($staff_no !== false) {
            $_SESSION['staff_no'] = $staff_no;
        } else {
            // セッションIDがない(初めてこのサイトに来ている)
            $res = $this->insertSession($staff_id);
            if ($res === true) {
                $_SESSION['staff_no'] = $this->db->getLastId();
            } else {
                $_SESSION['staff_no'] = '';
            }
        }
    }

    private function selectSession()
    {
        $table = ' staff_session ';
        $col = ' staff_no ';
        $where = ' session_key = ?';
        $arrVal = [$this->session_key];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res[0]['staff_no'] : false;
    }

    private function insertSession($staff_id)
    {
        $table = ' session ';
        $insData = ['session_key ' => $this->session_key, 'staff_id' => $staff_id];
        $res = $this->db->insert($table, $insData);
        return $res;
    }
}
