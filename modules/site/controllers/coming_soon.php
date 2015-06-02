<?php

if (isset($_POST['email'])) {
  if (empty(strip_tags($_POST['email']))) {
    Message::register(new Message(Message::DANGER, '请填写邮箱地址'));
  } else {
    sendemailAdmin('Site under construction - requester', 'Email: ' . strip_tags($_POST['email']));
    Message::register(new Message(Message::SUCCESS, '提交成功，感谢您的支持！'));
  }
}

$html = new HTML();

$html->renderOut('site/desktop/components/html_header', array(
    'body_class' => 'home',
    'title' => $settings['sitename']
));
$html->renderOut('site/comming_soon');
$html->renderOut('site/desktop/components/html_footer');