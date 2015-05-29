<?php
$url = $_POST['url'];

try {
  load_library_simple_html_dom();
  $dom = file_get_html($url);

  if ($dom == false) {
    echo 'Can not read url as dom: ' . $url;
    exit;
  }
  
  // check if already imported
  $original_id = $dom->find('#dotdId',0)->value;
  if (Deal::findByOriginalId($original_id)) {
    echo 'Already imported.';
    exit;
  }
  
  // import
  $expired_at = $dom->find('.jcurrentTimeLeft',0) && $dom->find('.jcurrentTimeLeft',0)->value ? $dom->find('.jcurrentTimeLeft',0)->value+time() : null;
  
  $deal = new Deal();
  $deal->setVendor(Groupon::VENDOR);
  $deal->setOriginalId(trim($dom->find('#dotdId',0)->value));
  $deal->setTitle(trim($dom->find('#contentDealTitle a',0)->innertext));
  $deal->setOriginalUrl($url);
  $deal->setDescription($dom->find('.contentDealDescriptionFacts',0)->innertext . $dom->find('.contentDealDetails',0)->innertext);
  $deal->setExpiredAt($expired_at);
  $deal->setCreatedAt(time());
  if ($deal->save()) {
    load_library_wide_image();
    
    // save thumbnail
    $src = $dom->find('#jBuyDealBigImage img',0)->src;
    $image = WideImage::load($src);
    $image = $image->resize(300, 200, 'inside');
    $image = $image->resizeCanvas(300, 200, 'center', 'center', $image->allocateColor(255, 255, 255));
    try {
      $path = DEAL_THUMBNAIL_FOLDER . DS . 'deal-'.$deal->getId().'.jpg';
      $image->saveToFile($path);
      $deal->setThumbnail(str_replace(WEBROOT . DS, '', $path));
      if ($deal->save()) {
//        echo 'success';
      } else {
        echo 'Error when saving deal.';
      }
    } catch(Exception $e) {
      echo 'Error when saving image: ' . $e->getMessage();
    }
    
    // save image
    $src = $dom->find('#jBuyDealBigImage img',0)->src;
    $image = WideImage::load($src);
    $image = $image->resize(750, 500, 'inside');
    $image = $image->resizeCanvas(750, 500, 'center', 'center', $image->allocateColor(255, 255, 255));
    $watermark = WideImage::load(WEBROOT . DS . "modules/groupon/assets/images/groupon-logo.png");
    $image = $image->merge($watermark, 'left+10', 'bottom-10', 50);
    try {
      $path = DEAL_IMAGES_FOLDER . DS . 'deal-'.$deal->getId().'.jpg';
      $image->saveToFile($path);
      $deal->setImages(str_replace(WEBROOT . DS, '', $path));
      if ($deal->save()) {
        echo 'success';
      } else {
        echo 'Error when saving deal.';
      }
    } catch(Exception $e) {
      echo 'Error when saving image: ' . $e->getMessage();
    }
    
  } else {
    echo 'Failed to save new Deal object';
  }
} catch(Exception $e) {
  echo $e->getMessage();
  exit;
}