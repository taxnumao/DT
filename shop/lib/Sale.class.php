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

    public function orderItem($customer_no, $dataArr) 
    {
        // 初期化
        $res = [];

        // saleの登録
        $table = 'sale';
        $insData = ['customer_no' => $customer_no, 'sale_date' => date("Y/m/d H:i:s")];
        $res[] = $this->db->insert($table, $insData);

        // sale_detailの登録
        $sale_no = $this->db->getLastId();
        $table = 'sale_detail';
        for ($i = 0; $i < count($dataArr); $i ++) {
            $insData = ['sale_no' => $sale_no, 'item_id' => $dataArr[$i]['item_id'], 'price' => $dataArr[$i]['price'], 'num' => $dataArr[$i]['num']];
            $res[] = $this->db->insert($table, $insData);
        }

        // カートのリセット
        $res[] = $this->orderItemReset($dataArr);

        return $res;
    }

    public function orderItemReset($dataArr)
    {
        $table = 'cart';
        $insData = ['delete_flg' => 1];
        $where = 'crt_id = ?';

        for ($i = 0; $i < count($dataArr); $i ++) {
            $arrWhereVal = [$dataArr[$i]['crt_id']];
            $res = $this->db->update($table, $insData, $where, $arrWhereVal);
        }
        return $res;
    }


    // 売上情報を取得
    public function getSaleData($customer_no)
    {
        $table = ' sale_detail d LEFT JOIN sale s ON d.sale_no = s.sale_no LEFT JOIN item i ON i.item_id = d.item_id';
        $where = ' s.customer_no = ? ';
        $arrVal = [$customer_no];

        return $this->db->select($table, $column = '', $where, $arrVal);
    }

}