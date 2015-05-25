<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - title
 * - password
 * - email
 * - description_en
 * - description_zh
 * - active
 * - hot
 * - price
 * - images
 * - thumbnail
 */
class BaseProject extends DBObject {
  /**
   * Implement parent abstract functions
   */
  protected function setPrimaryKeyName() {
    $this->primary_key = array(
      'id'
    );
  }
  protected function setPrimaryKeyAutoIncreased() {
    $this->pk_auto_increased = TRUE;
  }
  protected function setTableName() {
    $this->table_name = 'project';
  }
  
  /**
   * Setters and getters
   */
   public function setId($var) {
     $this->setDbFieldId($var);
   }
   public function getId() {
     return $this->getDbFieldId();
   }
   public function setTitle($var) {
     $this->setDbFieldTitle($var);
   }
   public function getTitle() {
     return $this->getDbFieldTitle();
   }
   public function setPassword($var) {
     $this->setDbFieldPassword($var);
   }
   public function getPassword() {
     return $this->getDbFieldPassword();
   }
   public function setEmail($var) {
     $this->setDbFieldEmail($var);
   }
   public function getEmail() {
     return $this->getDbFieldEmail();
   }
   public function setDescriptionEn($var) {
     $this->setDbFieldDescription_en($var);
   }
   public function getDescriptionEn() {
     return $this->getDbFieldDescription_en();
   }
  public function setDescription($var, $lang = null) {
    $lang = is_null($lang) ? get_language() : $lang;
    
    $method = "setDescription" . ucfirst($lang);
    $this->{$method}($var);
  }
  public function getDescription($lang = null) {
    $lang = is_null($lang) ? get_language() : $lang;
    
    $method = "getDescription" . ucfirst($lang);
    return $this->{$method}();
  }
   public function setDescriptionZh($var) {
     $this->setDbFieldDescription_zh($var);
   }
   public function getDescriptionZh() {
     return $this->getDbFieldDescription_zh();
   }
   public function setActive($var) {
     $this->setDbFieldActive($var);
   }
   public function getActive() {
     return $this->getDbFieldActive();
   }
   public function setHot($var) {
     $this->setDbFieldHot($var);
   }
   public function getHot() {
     return $this->getDbFieldHot();
   }
   public function setPrice($var) {
     $this->setDbFieldPrice($var);
   }
   public function getPrice() {
     return $this->getDbFieldPrice();
   }
   public function setImages($var) {
     $this->setDbFieldImages($var);
   }
   public function getImages() {
     return $this->getDbFieldImages();
   }
   public function setThumbnail($var) {
     $this->setDbFieldThumbnail($var);
   }
   public function getThumbnail() {
     return $this->getDbFieldThumbnail();
   }

  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('project');
  }
  
  static function tableExist() {
    return parent::tableExistByName('project');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `project` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(512) NOT NULL ,
  `password` VARCHAR(20) ,
  `email` VARCHAR(30) ,
  `description_en` TEXT ,
  `description_zh` TEXT ,
  `active` TINYINT(1) DEFAULT 1 ,
  `hot` TINYINT(1) DEFAULT 1 ,
  `price` DECIMAL(6) DEFAULT 0 ,
  `images` VARCHAR(800) ,
  `thumbnail` VARCHAR(100) ,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id, $instance = 'Project') {
    global $mysqli;
    $query = 'SELECT * FROM project WHERE id=' . $id;
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new $instance();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  static function findAll() {
    global $mysqli;
    $query = "SELECT * FROM project";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Project();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM project LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Project();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM project";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function truncate() {
    global $mysqli;
    $query = "TRUNCATE TABLE project";
    return $mysqli->query($query);
  }
}