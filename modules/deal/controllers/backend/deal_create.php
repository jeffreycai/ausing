<?php

$object = new Deal();
  
// handle form submission
if (isset($_POST['submit'])) {
  $error_flag = false;

  /// validation
  
  // validation for $title
  $title = isset($_POST["title"]) ? $_POST["title"] : null;  
  // validation for $vendor
  $vendor = isset($_POST["vendor"]) ? strip_tags($_POST["vendor"]) : null;  
  // validation for $affiliate_url
  $affiliate_url = isset($_POST["affiliate_url"]) ? strip_tags($_POST["affiliate_url"]) : null;  
  // validation for $original_url
  $original_url = isset($_POST["original_url"]) ? strip_tags($_POST["original_url"]) : null;  
  // validation for $thumbnail
  $thumbnail = isset($_POST["thumbnail"]) ? strip_tags(trim($_POST["thumbnail"])) : null;  
  // validation for $images
  $images = isset($_POST["images"]) ? strip_tags(trim($_POST["images"])) : null;  
  // validation for $description
  $description = isset($_POST["description"]) ? $_POST["description"] : null;  
  // validation for $wechat_description
  $wechat_description = isset($_POST["wechat_description"]) ? $_POST["wechat_description"] : null;  
  // validation for $created_at
  $created_at = isset($_POST["created_at"]) ? strip_tags($_POST["created_at"]) : null;
  if (empty($created_at)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "created_at is required.", "zh" => "请填写created_at"))));
    $error_flag = true;
  }
  
  // validation for $expired_at
  $expired_at = isset($_POST["expired_at"]) ? strip_tags($_POST["expired_at"]) : null;  
  // validation for $published
  $published = isset($_POST["published"]) ? 1 : 0;  
  // validation for $valid
  $valid = isset($_POST["valid"]) ? 1 : 0;  /// proceed submission
  
  // proceed for $title
  $object->setTitle($title);
  
  // proceed for $vendor
  $object->setVendor($vendor);
  
  // proceed for $affiliate_url
  $object->setAffiliateUrl($affiliate_url);
  
  // proceed for $original_url
  $object->setOriginalUrl($original_url);
  
  // proceed for $thumbnail
  $object->setThumbnail($thumbnail);
  
  // proceed for $images
  $object->setImages($images);
  
  // proceed for $description
  $object->setDescription($description);
  
  // proceed for $wechat_description
  $object->setWechatDescription($wechat_description);
  
  // proceed for $created_at
  $object->setCreatedAt($created_at);
  
  // proceed for $expired_at
  $object->setExpiredAt($expired_at);
  
  // proceed for $published
  $object->setPublished($published);
  
  // proceed for $valid
  $object->setValid($valid);
  if ($error_flag == false) {
    if ($object->save()) {
      Message::register(new Message(Message::SUCCESS, i18n(array("en" => "Record saved", "zh" => "记录保存成功"))));
      HTML::forwardBackToReferer();
    } else {
      Message::register(new Message(Message::DANGER, i18n(array("en" => "Record failed to save", "zh" => "记录保存失败"))));
    }
  }
}



$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array(
  'en' => 'Create Deal',
  'zh' => 'Create 折扣',
  )),
));
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('deal/backend/deal_create', array(
  'object' => $object
));


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

