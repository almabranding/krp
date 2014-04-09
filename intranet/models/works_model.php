<?php

class Works_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function form($id = null) {
        $action = ($id == null) ? URL . 'works/add' : URL . 'works/edit/' . $id;
        $desc = $this->getWorks($id);
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('addModel', 'POST', $action, $atributes);

        $form->add('hidden', '_add', 'work');

        $form->add('label', 'label_visibility', 'visibility', 'Visibility:');
        $obj = $form->add('select', 'visibility', $desc['visibility'], array('autocomplete' => 'off'));
        $obt[1] = 'Public';
        $obt[0] = 'Private';
        $obj->add_options($obt, true);
        unset($obt);
        foreach ($this->_langs as $lng) {
            $desc = $this->getWorks($id, $lng);
            $form->add('label', 'label_name_' . $lng, 'name_' . $lng, 'Name ' . $lng);
            $form->add('text', 'name_' . $lng, $desc['name'], array('autocomplete' => 'off', 'required' => array('error', 'Name is required!')));
            $obj = $form->add('label', 'label_content_' . $lng, 'content_' . $lng, 'Content ' . $lng);
            $obj->set_attributes(array(
                'style' => 'float:none',
            ));
            $obj = $form->add('textarea', 'content_' . $lng, ($desc['content']), array('autocomplete' => 'off'));
            $obj->set_attributes(array(
                'class' => 'wysiwyg',
            ));
        }
        $form->add('submit', '_btnsubmit', 'Submit');
        $form->validate();
        return $form;
    }

    public function toTable($lista, $order = null) {
        $order = explode(' ', $order);
        $orden = (strtolower($order[1]) == 'desc') ? ' ASC' : ' DESC';
        $b['sort'] = true;
        $b['title'] = array(
            array(
                "title" => "Thumbnail",
                "link" => URL . LANG . '/contacts/lista/' . $this->pag . '/name' . $orden,
                "width" => "10%"
            ), array(
                "title" => "Name",
                "link" => URL . LANG . '/contacts/lista/' . $this->pag . '/email' . $orden,
                "width" => "40%"
            ), array(
                "title" => "Updated",
                "link" => URL . LANG . '/contacts/lista/' . $this->pag . '/created_at' . $orden,
                "width" => "10%"
            ), array(
                "title" => "Options",
                "link" => "#",
                "width" => "5%"
        ));
        foreach ($lista as $key => $value) {
            $b['values'][] = array(
                "Image" => '<img height="80" src="' . URL . UPLOAD . $this->getRouteImg($value['photos'][0]['img_date']) . $value['photos'][0]['file_name'] . '">',
                "Name" => $value['name'],
                "Created" => $value['updated_at'],
                "Options" => '<a href="' . URL . 'works/photos/' . $value['work_id'] . '"><button title="Edit" type="button" class="edit"></button></a><button type="button" title="Delete" class="delete" onclick="secureMsg(\'Are you sure you want to delete?\', \'works/delete/' . $value['work_id'] . ' \');"></button>'
            );
        }
        return $b;
    }

    public function getWorks($id, $lang = LANG) {
        if ($id == null) {
            $works = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'works a JOIN ' . DB_PREFIX . 'works_description ad ON (ad.work_id=a.id) WHERE ad.language_id="' . $lang . '"');
            foreach ($works as $key => $work) {
                $images = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'works_photos wp JOIN ' . DB_PREFIX . 'photos p ON (wp.photo_id=p.id) WHERE work_id="' . $work['work_id'] . '" order by position');
                $works[$key]['photos'] = $images;
            }
        } else {
            $works = $this->db->selectOne('SELECT * FROM ' . DB_PREFIX . 'works a JOIN ' . DB_PREFIX . 'works_description ad ON (ad.work_id=a.id)  WHERE a.id=' . $id . ' AND ad.language_id="' . $lang . '"');
            $images = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'works_photos wp JOIN ' . DB_PREFIX . 'photos p ON (wp.photo_id=p.id) WHERE work_id="' . $works['work_id'] . '" order by position');
            $works['photos'] = $images;
        }

        return $works;
    }

    public function edit($id) {
        $data = array(
            'visibility' => $_POST['visibility'],
            'updated_at' => $this->getTimeSQL(),
                //'url' => filter_var(urlencode(strtolower($_POST['name'])), FILTER_SANITIZE_URL),
        );
        $this->db->update(DB_PREFIX . 'works', $data, "`id` = '{$id}'");
        unset($data);
        $data['work_id'] = $id;
        foreach ($this->_langs as $lng) {
            $data['name'] = stripslashes($_POST['name_' . $lng]);
            $data['content'] = stripslashes($_POST['content_' . $lng]);
            $data['language_id'] = $lng;
            $exist = $this->db->select("SELECT * FROM " . DB_PREFIX . "works_description WHERE work_id=" . $id . " AND `language_id`='" . $lng . "'");
            if (sizeof($exist))
                $this->db->update(DB_PREFIX . 'works_description', $data, "`work_id` = '{$id}' AND `language_id` = '{$lng}'");
            else
                $this->db->insert(DB_PREFIX . 'works_description', $data);
        }
    }

    public function add() {
        $data = array(
            'visibility' => $_POST['visibility'],
            'created_at' => $this->getTimeSQL(),
            'updated_at' => $this->getTimeSQL(),
        );
        $id = $this->db->insert(DB_PREFIX . 'works', $data);
        unset($data);
        $data['work_id'] = $id;
        foreach ($this->_langs as $lng) {
            $data['name'] = stripslashes($_POST['name_' . $lng]);
            $data['content'] = stripslashes($_POST['content_' . $lng]);
            $data['language_id'] = $lng;
            $this->db->insert(DB_PREFIX . 'works_description', $data);
        }
        return $id;
    }

    public function delete($id) {
        $photos = $this->db->select('SELECT * FROM ' . DB_PREFIX . 'works_photos WHERE work_id=:id', array('id' => $id));
        foreach ($photos as $photo) {
            $this->deleteImage($photo['photo_id']);
            $this->db->delete(DB_PREFIX . 'works_photos', "`photo_id` = {$photo['photo_id']}");
        }
        $this->db->delete(DB_PREFIX . 'works', "`id` = {$id}");
        $this->db->delete(DB_PREFIX . 'works_description', "`work_id` = {$id}");
    }

    public function sort() {
        foreach ($_POST['foo'] as $key => $value) {
            $data = array(
                'position' => $key
            );
            $this->db->update(DB_PREFIX . 'models_photos', $data, "`photo_id` = '{$value}'");
        }
        exit;
    }

    public function sortGroup() {
        foreach ($_POST['foo'] as $key => $value) {
            $data = array(
                'position' => $key,
                'group' => $_POST['group']
            );
            $this->db->update(DB_PREFIX . 'models_photos', $data, "`photo_id` = '{$value}'");
        }
        exit;
    }

    public function deleteImage($id) {
        $img = $this->getImageInfo($id);
        @unlink(UPLOAD . $this->getRouteImg($img['img_date']) . $img['file_name']);
        @unlink(UPLOAD . $this->getRouteImg($img['img_date']) . 'thumb_' . $img['file_name']);
        @unlink(UPLOAD . $this->getRouteImg($img['img_date']) . 'original/' . $img['file_name']);
        $this->db->delete(DB_PREFIX . 'photos', "`id` = {$id}");
        return true;
    }

    public function getImageInfo($id) {
        return $this->db->selectOne('SELECT * FROM ' . DB_PREFIX . 'photos p JOIN ' . DB_PREFIX . 'works_photos mp ON(p.id=mp.photo_id) WHERE p.id = :id', array('id' => $id));
    }

    public function selectHeadsheet($id) {
        echo $id;
        foreach ($_POST['check'] as $key => $value) {
            $data = array(
                'main' => 0
            );
            $this->db->update(DB_PREFIX . 'works_photos', $data, "`work_id` = '{$id}'");
            $data = array(
                'main' => 1
            );
            $this->db->update(DB_PREFIX . 'works_photos', $data, "`photo_id` = '{$value}'");
        }
        exit;
    }

    public function editImage($id) {
        $Models_photos = $this->getModels_photos($id);
        $Models_photos = $Models_photos[0];
        $modelo = $this->getModel($Models_photos['model_id']);
        Logs::set("Ha modificado una imagen del modelo " . $modelo['name']);
        $data = array(
            'caption' => $_POST['caption'],
            'photographer' => $_POST['photographer'],
            'updated_at' => $this->getTimeSQL(),
        );
        $this->db->update('photos', $data, "`id` = '{$id}'");
        $data = array(
            'visibility' => $_POST['visibility'],
            'updated_at' => $this->getTimeSQL(),
        );
        $this->db->update(DB_PREFIX . 'models_photos', $data, "`photo_id` = '{$id}'");
        return $Models_photos['model_id'];
    }
    public function addPhoto($id, $img) {
        $data = array(
            'work_id' => $id,
            'photo_id' => $img['id']
        );
        $this->db->insert(DB_PREFIX . 'works_photos', $data);
    }

    public function saveInputs() {
        foreach ($_POST['caption'] as $key => $value) {
            $data = array(
                'caption' => $value
            );
            $this->db->update(DB_PREFIX . 'photos', $data, "`id` = '{$key}'");
        }
    }

    public function deleteSelected() {
        foreach ($_POST['check'] as $key => $value) {
            $this->deleteImage($value);
        }
    }

}
