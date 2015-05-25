<?php

$object = new Project();
  
// handle form submission
if (isset($_POST['submit'])) {
  $error_flag = false;

  /// validation
  
  // validation for $title
  $title = isset($_POST["title"]) ? strip_tags($_POST["title"]) : null;
  if (empty($title)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "title is required.", "zh" => "请填写title"))));
    $error_flag = true;
  }

  if (strlen($title) >= 150) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "Max length for title is 150", "zh" => "title 不能超过150个字符"))));
    $error_flag = true;
  }
  
  // validation for $password
  $password = isset($_POST["password"]) ? strip_tags($_POST["password"]) : null;
  $retype_password = isset($_POST["retype_password"]) ? strip_tags($_POST["retype_password"]) : null;
  if (empty($password)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "password is required.", "zh" => "请填写password"))));
    $error_flag = true;
  }

  if (strlen($password) >= 15) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "Max length for password is 15", "zh" => "password 不能超过15个字符"))));
    $error_flag = true;
  }

  if ($password != $retype_password) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "Retype value does not match for password", "zh" => "再次输入的password与原值不匹配"))));
    $error_flag = true;
  }
  
  // validation for $email
  $email = isset($_POST["email"]) ? strip_tags($_POST["email"]) : null;
  $retype_email = isset($_POST["retype_email"]) ? strip_tags($_POST["retype_email"]) : null;
  if (empty($email)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "email is required.", "zh" => "请填写email"))));
    $error_flag = true;
  }

  if (strlen($email) >= 30) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "Max length for email is 30", "zh" => "email 不能超过30个字符"))));
    $error_flag = true;
  }

  if ($email != $retype_email) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "Retype value does not match for email", "zh" => "再次输入的email与原值不匹配"))));
    $error_flag = true;
  }
  
  // validation for $description_en
  $description_en = isset($_POST["description_en"]) ? $_POST["description_en"] : null;  
  // validation for $description_zh
  $description_zh = isset($_POST["description_zh"]) ? $_POST["description_zh"] : null;
  if (empty($description_zh)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "description_zh is required.", "zh" => "请填写description_zh"))));
    $error_flag = true;
  }
  
  // validation for $active
  $active = isset($_POST["active"]) ? 1 : 0;  
  // validation for $owners
  $owners = isset($_POST["owners"]) ? $_POST["owners"] : null;
  if (empty($owners)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "owners is required.", "zh" => "请填写owners"))));
    $error_flag = true;
  }
  
  // validation for $price
  $price = isset($_POST["price"]) ? strip_tags($_POST["price"]) : null;  
  // validation for $images
  $images = isset($_POST["images"]) ? strip_tags(trim($_POST["images"])) : null;  
  // validation for $thumbnail
  $thumbnail = isset($_POST["thumbnail"]) ? strip_tags(trim($_POST["thumbnail"])) : null;
  if (empty($thumbnail)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "thumbnail is required.", "zh" => "请填写thumbnail"))));
    $error_flag = true;
  }
  /// proceed submission
  
  // proceed for $title
  $object->setTitle($title);
  
  // proceed for $password
  $object->setPassword($password);
  
  // proceed for $email
  $object->setEmail($email);
  
  // proceed for $description_en
  $object->setDescriptionEn($description_en);
  
  // proceed for $description_zh
  $object->setDescriptionZh($description_zh);
  
  // proceed for $active
  $object->setActive($active);
  
  // proceed for $owners
 // TODO
  
  // proceed for $price
  if (!empty($price)) {
    $object->setPrice($price);
  }
  
  // proceed for $images
  $object->setImages($images);
  
  // proceed for $thumbnail
  $object->setThumbnail($thumbnail);
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
  'en' => 'Create Project',
  'zh' => 'Create 项目',
  )),
));
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('project/backend/project_create', array(
  'object' => $object
));


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

