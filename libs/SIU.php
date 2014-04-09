<?php

class SIU extends Model
{
    public $_attributesList=array('height','bust','waist','chest','hips','shoes','hair','eyes','ethnicity','dress','collar','trousers');
    public $_attributes=array('waist','hips','dress','collar','trousers','jacket');
    public $_Shoes=array('35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');
    public $_euShoes=array('35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');
    public $_usShoesW=array('5','6','7','8','9','10','11','12','13','14','','','','','','');
    public $_usShoesM=array('','','','5','6','7 ','8','9','10','11','12','13','14','15','16','17');
    public $_usHeight=array('35','35/36','36','37','37/38','38','38/39','40','41','42','43','44','45','46','46/47');
    public $_lang=array();
    public $_language=array();
    function __construct() {
         $this->setLang(LANG);
         parent::__construct();
    }
    public function getListAttr()
    {
        return $this->_attributesList ;
    }
    public function setLang($langSel)
    {
         require $_SERVER['DOCUMENT_ROOT'].'/lang/'.$langSel.'/default.php';
         $this->_lang=$lang;
         $this->_language=$langSel;
    }
    public function getShoesSizes(){
       $_Shoes=array('35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');
       return $_Shoes;
    }
    public function getSiu($model)
    {
        $siu['bust']=$model['bust'];
        $siu['hair']=$this->_lang[$this->getAttribute($model['hair_type_id'])];
        $siu['eyes']=$this->_lang[$this->getAttribute($model['eye_type_id'])];
        $siu['shoes']=$model['shoes'];
        $siu['height']=$model['height_feet'].'\'\''.$model['height_inches'].'\'';
        $siu['waist']=$model['waist'];
        $siu['hips']=$model['hips'];
        return $siu;
    }
    public function getAttribute($att)
    {
        $type=$this->getAtributes($att);
        return $type['name'];
    }
    public function getHeight($size)
    {
        if(!$size) return;
        switch ($this->_language){
            case 'ES': 
                return $size.' <span style="text-transform:none">cm</span>';                
                break;
            case 'EN':
                $inches = $size/2.54;
                $feet = ($inches/12);
                $inches = $inches%12;
                return sprintf('%d \' %d \'\'', $feet, $inches);

            default:
                return $size.' <span style="text-transform:none">cm</span>';          
                
        }
    }
    public function getInches($size)
    {
        if(!$size) return;
        switch ($this->_language){
            case 'ES': 
                return $size.' <span style="text-transform:none">cm</span>';           
                break;
            case 'CH': 
                return $size.' <span style="text-transform:none">cm</span>';           
                break;
            case 'EN':
                return intval($size/2.54).'\'\'';
            default:
                return $size.' <span style="text-transform:none">cm</span>';           
                
        }
    }
    public function getShoes($size,$sex)
    {
        $clave = array_search($size, $this->_Shoes);
        if(!$clave) return;
        switch ($this->_language){
            case 'ES': 
                return $this->_euShoes[$clave].' EU';                
                break;
            case 'CH': 
                return $this->_euShoes[$clave].' EU';               
                break;
            case 'EN':
                return ($sex=2)?$this->_usShoesM[$clave].' US':$this->_usShoesW[$clave].' US';
                break;
            default: 
                return $this->_euShoes[$clave];       
                
        }
    } 
    public function getAtributes($type){
         return $this->db->selectOne('SELECT * FROM '.DB_PREFIX.'attributes WHERE id="'.$type.'"');  
    }
    
}