<?php

require_once __DIR__ .'/../../../../bootstrap.php';
$rtn = new stdClass();

if (!User::getInstance()->isLogin()) {
  $rtn->error = i18n(array('en' => 'Authorisation required.', 'zh' => '抱歉，您没有权限进行此操作'));
  echo json_encode($rtn);
  exit;
}

$upload_dir = "files/fields/images";

if (isset($_FILES)) {
  $files = array();
  // create upload dir if not exist
  mkdir_recursively(WEBROOT . DS . $upload_dir);
//print_r($_FILES);
  foreach ($_FILES as $file) {
    $name = strtolower(preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']));
    $tokens = explode('.', $name);
    $tokens[0] = $tokens[0] . '_' . rand(100, 999);
    $name = implode('.', $tokens);
    $type = $file['type'];
    $tmp_location = $file['tmp_name'];
    $error = $file['error'];
    $error_msg = null;
    $size = $file['size'];
    // validation
    if (!preg_match('/^image/', $type)) {
      $error_msg = i18n(array(
          'en' => 'Upload file needs to be an image file',
          'zh' => '上传文件需为图片文件'
      ));
    } else if ($size > (1 * 1000 * 1000)) {
      $error_msg = i18n(array(
          'en' => 'Max upload file size should be less than',
          'zh' => '最大上传文件应小于'
      )) . ' 1MB';
    }
    if ($error_msg) {
      $rtn->error = $error_msg;
    } else {
      load_library_wide_image();
      $dest_location = WEBROOT . DS . $upload_dir . DS . $name;
      
      try {
        $image = WideImage::load($tmp_location);
        unlink($tmp_location);
        $refill = "0,0,0";
        $watermark = WEBROOT . DS . 'modules/site/assets/images/favicon.png';
        if ($refill) {
          $bgcolor = $image->allocateColor(0,0,0);
          $image = $image->resize(500, 320, 'inside')->resizeCanvas(500, 320, 'center', 'center', $bgcolor);
        } else {
          $image = $image->resize(500, 320, 'outside')->resizeCanvas(500, 320, 'center', 'center');
        }

        if ($watermark) {
          $watermark = WideImage::load(WEBROOT . DS . "modules/site/assets/images/favicon.png");
          $image = $image->merge($watermark, 'right-10', 'bottom-10', 50);
        }
        $image->saveToFile($dest_location);

        $rtn->uri = "$upload_dir/" . $name;
      } catch (Exception $e) {
        $rtn->error = 'WideImage error: ' . $e->getMessage();
      }
    }
    
    echo json_encode($rtn);
    exit;
  }
}