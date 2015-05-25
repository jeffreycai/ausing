<?php

// override this call if "site" module has the override controller
$override_controller = MODULESROOT . '/site/controllers/siteuser/unauthorised.php';
if (is_file($override_controller)) {
  require $override_controller;
  exit;
}



$html = new HTML();

$html->renderOut('core/backend/single_form_header', array('title' => i18n(array(
    'en' => 'Not authorised to visit page',
    'zh' => '没有访问页面的权限'
))));
$html->output("<p>".i18n(array(
    'en' => 'Sorry, you do not have permission to access this page',
    'zh' => '抱歉，您没有访问此页面的权限'
))."</p>");
$html->output("<p><a href='#' onclick='goback(); return false;'>".  i18n(array(
    'en' => 'Go back',
    'zh' => '返回'
))."</a>");
$html->output('<script type="text/javascript">function goback(){window.history.back();}</script>');
$html->renderOut('core/backend/single_form_footer');

exit;