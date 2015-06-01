<?php

// define file paths
define('DEAL_THUMBNAIL_FOLDER', WEBROOT . DS . 'files/groupon/thumbnails');
define('DEAL_IMAGES_FOLDER', WEBROOT . DS . 'files/groupon/images');
if (!is_dir(DEAL_THUMBNAIL_FOLDER)) {
  mkdir(DEAL_THUMBNAIL_FOLDER);
}
if (!is_dir(DEAL_IMAGES_FOLDER)) {
  mkdir(DEAL_IMAGES_FOLDER);
}
if (!is_writable(DEAL_THUMBNAIL_FOLDER)) {
  die('DEAL_THUMBNAIL_FOLDER needs to be writable.');
}
if (!is_writable(DEAL_IMAGES_FOLDER)) {
  die('DEAL_IMAGES_FOLDER needs to be writable.');
}



// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-folder-open"></i> '.i18n(array('en' => 'Deal','zh' => '折扣',)).'<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/deal/list').'">'.i18n(array(
          'en' => 'List',
          'zh' => '列表'
      )).'</a></li>
      <li><a href="'.uri('admin/deal/create').'">'.i18n(array(
          'en' => 'Create',
          'zh' => '创建'
      )).'</a></li>
    </ul>
  </li>
  '        
  );
}