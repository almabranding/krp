<?php

class Archive_Model extends Model {

    public function __construct() {
        parent::__construct();
    }
    public function getWorks($id, $lang = LANG) {
        if ($id == null) {
            $works = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'archive a JOIN ' . DB_PREFIX . 'archive_description ad ON (ad.archive_id=a.id) WHERE ad.language_id="' . $lang . '"');
            foreach ($works as $key => $work) {
                $images = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'archive_photos wp JOIN ' . DB_PREFIX . 'photos p ON (wp.photo_id=p.id) WHERE archive_id="' . $work['archive_id'] . '" order by main, position');
                $works[$key]['photos'] = $images;
            }
        } else {
            $works = $this->db->selectOne('SELECT * FROM ' . DB_PREFIX . 'archive a JOIN ' . DB_PREFIX . 'archive_description ad ON (ad.archive_id=a.id)  WHERE a.id=' . $id . ' AND ad.language_id="' . $lang . '"');
            $images = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'archive_photos wp JOIN ' . DB_PREFIX . 'photos p ON (wp.photo_id=p.id) WHERE archive_id="' . $works['archive_id'] . '" order by main, position');
            $works['photos'] = $images;
        }
        return $works;
    }

}
