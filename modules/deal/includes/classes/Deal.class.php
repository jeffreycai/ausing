<?php
require_once "BaseDeal.class.php";

class Deal extends BaseDeal {
  static function findByOriginalId($oid) {
    global $mysqli;
    $query = 'SELECT * FROM deal WHERE original_id=' . $oid;
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new Deal();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  static function findbyOriginalUrl($url) {
    global $mysqli;
    $query = 'SELECT * FROM deal WHERE original_url=' . DBObject::prepare_val_for_sql($url);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new Deal();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  static function findbyOriginalUrlInValid($url) {
    global $mysqli;
    $query = 'SELECT * FROM deal WHERE valid=1 AND original_url=' . DBObject::prepare_val_for_sql($url);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new Deal();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  public function delete() {
    @unlink(WEBROOT . DS  .$this->getThumbnail());
    $images = explode("\n", $this->getImages());
    foreach ($images as $image) {
      @unlink(WEBROOT . DS . trim($image));
    }
    return parent::delete();
  }
}
