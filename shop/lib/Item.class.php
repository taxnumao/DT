<?php
/*
 * ファイルパス : \Application\xampp\htdocs\DT\shop\lib\Item.class.php
 * ファイル名 : Item.class.php(商品に関するプログラムのクラスファイル、Model)
 */
namespace shop\lib;

class Item {
    public $cateArr = [];
    public $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    // カテゴリーリストの取得
    public function getCategoryList() {
        $table = ' category ';
        $col = ' ctg_id, category_name ';
        $res = $this->db->select($table, $col);
        return $res;
    }

    // 商品リストを取得
    public function getItemList($ctg_id) {
        // カテゴリーによって表示させるアイテムを変える
        $table = ' item ';
        $col = ' item_id, item_name, price, image, ctg_id ';
        $where = ($ctg_id !== '') ? ' ctg_id = ? ' : '';
        $arrVal = ($ctg_id !== '') ? [$ctg_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }

    //  商品の詳細情報を取得
    public function getItemDetailData($item_id) {
        $table = 'item';
        $col = 'item_id, item_name, detail, price, image, ctg_id';
        
        $where = ($item_id !== '') ? ' item_id = ? ' : '';
        // カテゴリーによって表示させるアイテムを変える
        $arrVal = ($item_id !== '') ? [$item_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }

    // 検索窓の商品を取得
    public function getItemSearch($text) {
         $table = 'item';
         $col = 'item_id, item_name, price, image, ctg_id, detail';
         $where = 'item_name LIKE ? OR detail LIKE ?';
         $arrVal = ["%" . $text . "%", "%" . $text . "%"];
 
         $res = $this->db->select($table, $col, $where, $arrVal);
 
         return ($res !== false && count($res) !== 0) ? $res : false;
    }
}