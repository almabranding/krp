<?php
class Media_Model extends Model {
    public $pag;
    public function __construct() {
        parent::__construct();
        $this->wherepag=' WHERE 1=1 ';
    }
    public function searchForm() {
        $action = URL . LANG . '/contacts/searchResult';
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('addModel', 'POST', $action, $atributes);

        $form->add('hidden', '_add', 'model');

        $form->add('label', 'label_name', 'name', 'Name');
        $form->add('text', 'name', '', array('autocomplete' => 'off'));
        
        $form->add('label', 'label_email', 'email', 'Email');
        $form->add('text', 'email', '', array('autocomplete' => 'off'));

        $form->add('submit', '_btnsubmit', 'Search');
        $form->validate();
        return $form;
    }
    public function formImage( $id = null) {

        $action = ($id == null) ? URL . LANG . '/media/editImage' : URL . LANG . '/media/editImage/' . $id;
        if ($id != null)
            $value = $this->getImageInfo;

        $form = new Zebra_Form('addProject', 'POST', $action);
        $pathinfo = pathinfo($value['img']);
        $form->add('hidden', '_add', 'page');
        $form->add('hidden', 'model_id', $value['model_id']);
        $form->add('hidden', 'originalName', $value['img']);
        $form->add('hidden', 'fileExt', $pathinfo['extension']);

        $form->add('label', 'label_caption', 'caption', 'Caption');
        $obj = $form->add('text', 'caption', $value['caption'], array('autocomplete' => 'off'));

        $form->add('submit', '_btnsubmit', 'Submit');
        $form->validate();
        return $form;
    }
  public function getImageInfo($id) {
        return $this->db->selectOne('SELECT * FROM ' . DB_PREFIX . 'photos p JOIN ' . DB_PREFIX . 'gallery_photos mp ON(p.id=mp.photo_id) WHERE p.id = :id', array('id' => $id));
    }
    public function getGalleryList($pag,$maxpp,$order='created_at',$lang=LANG) {
        $min=$pag*$maxpp-$maxpp;
        return $this->db->select("SELECT * FROM  ".DB_PREFIX."photos a JOIN ".DB_PREFIX."gallery_photos b ON a.id=b.photo_id ".$this->wherepag." ORDER by ".$order." LIMIT ".$min.",".$maxpp); 
    }
    public function toTable($lista,$order) {
        $order=  explode(' ', $order);
        $orden=(strtolower($order[1])=='desc')?' ASC':' DESC';
        $b['sort']=true;
        $b['title']=array(
           array(
               "title"  =>"Image",
                "link"  => URL.LANG.'/contacts/lista/'.$this->pag.'/name'.$orden,
               "width"  =>"10%"
           ),array(
               "title"  =>"Caption",
                "link"  => URL.LANG.'/contacts/lista/'.$this->pag.'/email'.$orden,
               "width"  =>"5%"
           ),array(
               "title"  =>"URL",
                "link"  => URL.LANG.'/contacts/lista/'.$this->pag.'/email'.$orden,
               "width"  =>"40%"
           ),array(
               "title"  =>"Created",
               "link"  => URL.LANG.'/contacts/lista/'.$this->pag.'/created_at'.$orden,
               "width"  =>"10%"   
           ),array(
               "title"  =>"Options",
               "link"  =>"#",
               "width"  =>"5%"
           ));       
        foreach($lista as $key => $value) {
            $b['values'][]=   
            array(
                "Image"  =>'<img height="80" src="'.URL.UPLOAD.$this->getRouteImg($value['img_date']).$value['file_name'].'">',
                "Caption"  =>$value['caption'],
                "URL"  =>WEB.'uploads/'.$this->getRouteImg($value['img_date']).$value['file_name'],
                "Created"  =>$this->getTimeStamp($value['img_date']),
                "Options"  =>'<a href="'.URL.'media/view/'.$value['photo_id'].'"><button title="Edit" type="button" class="edit"></button></a><button type="button" title="Delete" class="delete" onclick="secureMsg(\'Are you sure you want to delete?\', \'media/delete/'.$value['photo_id'].' \');"></button>'
            );
        }
        return $b;
    }
   
    public function edit($id){
        $data = array(
            'updated_at' => $this->getTimeSQL(),
        );
        $this->db->update('press', $data, "`id` = '{$id}'");
         foreach ($this->_langs as $lng) {
            $data = array(
                'press_id' => $id,
                'content' => $_POST['content_' . $lng],
                'name' => $_POST['name_' . $lng],
                'link' => $_POST['link']
            );
            $exist = $this->db->select("SELECT * FROM press_description WHERE press_id=" . $id . " AND `language_id`='" . $lng . "'");
            if (sizeof($exist))
                $this->db->update('press_description', $data, "`press_id` = '{$id}' AND `language_id` = '{$lng}'");
            else
                $this->db->insert('press_description', $data);
        }   
    }
    public function editImage($id) {
        $data = array(
            'caption' => $_POST['caption'],
            'updated_at' => $this->getTimeSQL(),
        );
        $this->db->update(DB_PREFIX.'photos', $data, "`id` = '{$id}'");
 
    }
    public function delete($id){
        $img=$this->getImageInfo($id);
       @unlink(ROOT.UPLOAD.$this->getRouteImg($img['img_date']).$img['file_name']);
         $this->db->delete( DB_PREFIX .'photos', "`id` = {$id}");
         $this->db->delete( DB_PREFIX .'gallery_photos', "`photo_id` = {$id}");  
    }   
    public function addPhoto($img) {
        $data = array(
            'photo_id' => $img['id'],
            'updated_at' => $this->getTimeSQL(),
            'created_at' => $this->getTimeSQL()
        );
        return $this->db->insert(DB_PREFIX . 'gallery_photos', $data);
    }
}