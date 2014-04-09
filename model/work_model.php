<?php

class Work_Model extends Model {

    public
            $_orden = 'name',
            $_where= 'WHERE 1=1',
            $_selection,
            $_alphabetic,
            $_sectionClass,
            $_flipbook;

    public function __construct() {
        parent::__construct();
    }

    public function getWorks($id, $lang = LANG) {
        if ($id == null) {
            $works = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'works a JOIN ' . DB_PREFIX . 'works_description ad ON (ad.work_id=a.id) WHERE ad.language_id="' . $lang . '"');
            foreach ($works as $key => $work) {
                $images = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'works_photos wp JOIN ' . DB_PREFIX . 'photos p ON (wp.photo_id=p.id) WHERE work_id="' . $work['work_id'] . '" order by main DESC, position');
                $works[$key]['photos'] = $images;
            }
        } else {
            $works = $this->db->selectOne('SELECT * FROM ' . DB_PREFIX . 'works a JOIN ' . DB_PREFIX . 'works_description ad ON (ad.work_id=a.id)  WHERE a.id=' . $id . ' AND ad.language_id="' . $lang . '"');
            $images = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'works_photos wp JOIN ' . DB_PREFIX . 'photos p ON (wp.photo_id=p.id) WHERE work_id="' . $works['work_id'] . '" order by main, position');
            $works['photos'] = $images;
        }
        return $works;
    }

}
