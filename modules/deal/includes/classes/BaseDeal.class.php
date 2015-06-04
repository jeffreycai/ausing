<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - vendor
 * - original_id
 * - title
 * - affiliate_url
 * - original_url
 * - thumbnail
 * - images
 * - description
 * - wechat_description
 * - created_at
 * - expired_at
 * - published
 * - valid
 */
class BaseDeal extends DBObject {
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
    $this->table_name = 'deal';
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
   public function setVendor($var) {
     $this->setDbFieldVendor($var);
   }
   public function getVendor() {
     return $this->getDbFieldVendor();
   }
   public function setOriginalId($var) {
     $this->setDbFieldOriginal_id($var);
   }
   public function getOriginalId() {
     return $this->getDbFieldOriginal_id();
   }
   public function setTitle($var) {
     $this->setDbFieldTitle($var);
   }
   public function getTitle() {
     return $this->getDbFieldTitle();
   }
   public function setAffiliateUrl($var) {
     $this->setDbFieldAffiliate_url($var);
   }
   public function getAffiliateUrl() {
     return $this->getDbFieldAffiliate_url();
   }
   public function setOriginalUrl($var) {
     $this->setDbFieldOriginal_url($var);
   }
   public function getOriginalUrl() {
     return $this->getDbFieldOriginal_url();
   }
   public function setThumbnail($var) {
     $this->setDbFieldThumbnail($var);
   }
   public function getThumbnail() {
     return $this->getDbFieldThumbnail();
   }
   public function setImages($var) {
     $this->setDbFieldImages($var);
   }
   public function getImages() {
     return $this->getDbFieldImages();
   }
   public function setDescription($var) {
     $this->setDbFieldDescription($var);
   }
   public function getDescription() {
     return $this->getDbFieldDescription();
   }
   public function setWechatDescription($var) {
     $this->setDbFieldWechat_description($var);
   }
   public function getWechatDescription() {
     return $this->getDbFieldWechat_description();
   }
   public function setCreatedAt($var) {
     $this->setDbFieldCreated_at($var);
   }
   public function getCreatedAt() {
     return $this->getDbFieldCreated_at();
   }
   public function setExpiredAt($var) {
     $this->setDbFieldExpired_at($var);
   }
   public function getExpiredAt() {
     return $this->getDbFieldExpired_at();
   }
   public function setPublished($var) {
     $this->setDbFieldPublished($var);
   }
   public function getPublished() {
     return $this->getDbFieldPublished();
   }
   public function setValid($var) {
     $this->setDbFieldValid($var);
   }
   public function getValid() {
     return $this->getDbFieldValid();
   }

  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('deal');
  }
  
  static function tableExist() {
    return parent::tableExistByName('deal');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `deal` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `vendor` VARCHAR(10) ,
  `original_id` VARCHAR(32) ,
  `title` VARCHAR(512) NOT NULL ,
  `affiliate_url` VARCHAR(512) NOT NULL ,
  `original_url` VARCHAR(512) ,
  `thumbnail` VARCHAR(50) ,
  `images` VARCHAR(1024) ,
  `description` TEXT ,
  `wechat_description` TEXT ,
  `created_at` INT ,
  `expired_at` INT ,
  `published` TINYINT(1) DEFAULT 0 ,
  `valid` TINYINT(1) DEFAULT 1 ,
  PRIMARY KEY (`id`)
 ,
INDEX `deal_original_id` (`original_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id, $instance = 'Deal') {
    global $mysqli;
    $query = 'SELECT * FROM deal WHERE id=' . $id;
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
    $query = "SELECT * FROM deal";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Deal();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM deal ORDER BY created_at DESC LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Deal();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM deal";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function truncate() {
    global $mysqli;
    $query = "TRUNCATE TABLE deal";
    return $mysqli->query($query);
  }
}