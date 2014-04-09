<?php

class Bg_Model extends Model {

    public function __construct() {
        parent::__construct();
        $this->wherepag = ' WHERE 1=1 ';
    }

    public function getBg($id=null,$order = 'position') {
        if($id==null) return $this->db->select("SELECT * FROM  " . DB_PREFIX . "photos a JOIN bg_photos b ON a.id=b.photo_id " . $this->wherepag . " ORDER by " . $order);
        else return $this->db->selectOne("SELECT * FROM  " . DB_PREFIX . "photos a JOIN bg_photos b ON a.id=b.photo_id " . $this->wherepag . " AND photo_id=:id ORDER by " . $order,array('id'=>$id));
    }

    public function addPhoto($img) {
        $data = array(
            'photo_id' => $img['id'],
            'updated_at' => $this->getTimeSQL(),
            'created_at' => $this->getTimeSQL()
        );
        return $this->db->insert('bg_photos', $data);
    }

    public function editPhoto($id) {
        $data = array(
            'caption' => $_POST['caption'],
            'updated_at' => $this->getTimeSQL(),
        );
        $this->db->update(DB_PREFIX . 'photos', $data, "`id` = '{$id}'");
    }

    public function deletePhoto($id) {
        $img = $this->getBg($id);
        @unlink(ROOT . UPLOAD . $this->getRouteImg($img['img_date']) . $img['file_name']);
        $this->db->delete(DB_PREFIX . 'photos', "`id` = {$id}");
        $this->db->delete(DB_PREFIX . 'gallery_photos', "`photo_id` = {$id}");
    }

}
