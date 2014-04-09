<?php

class Index_Model extends Model {

    public function __construct() {
        parent::__construct();
    }   
    public function getBg($id=null,$order = 'position') {
        if($id==null) return $this->db->select("SELECT * FROM  " . DB_PREFIX . "photos a JOIN bg_photos b ON a.id=b.photo_id " . $this->wherepag . " ORDER by RAND() LIMIT 0,9");
        else return $this->db->selectOne("SELECT * FROM  " . DB_PREFIX . "photos a JOIN bg_photos b ON a.id=b.photo_id " . $this->wherepag . " AND photo_id=:id ORDER by " . $order,array('id'=>$id));
    }
}