<?php

// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-folder-open"></i> Groupon <span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/groupon/import').'">'.i18n(array(
          'en' => 'Import',
          'zh' => '导入'
      )).'</a></li>
    </ul>
  </li>
  '        
  );
}