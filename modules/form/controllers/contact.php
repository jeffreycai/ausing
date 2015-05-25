<?php
//require_permission('Send emails');
/**** Handle submission (presentation can be overiden next) *****/
if (isset($_POST['submit'])) {
  $email = isset($_POST['contact']['email']) ? trim(strip_tags($_POST['contact']['email'])) : null;
  $name = isset($_POST['contact']['name']) ? trim(strip_tags($_POST['contact']['name'])) : null;
  $msg = isset($_POST['contact']['message']) ? trim(strip_tags($_POST['contact']['message'])) : null;

  /**  validation **/
  $messages = array();
  if (empty($name)) {
    $messages[] = new Message(Message::DANGER, i18n(array(
        'en' => 'Please enter your name',
        'zh' => '请填写您的姓名'
    )));
  }
  if (empty($email)) {
    $messages[] = new Message(Message::DANGER, i18n(array(
        'en' => 'Please enter your E-mail',
        'zh' => '请填写您的邮箱'
    )));
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $messages[] = new Message(Message::DANGER, i18n(array(
         'en' => 'Please enter a valid email address',
         'zh' => '请填写合法的邮箱地址'
     )));
  }
  if (empty($msg)) {
    $messages[] = new Message(Message::DANGER, i18n(array(
        'en' => 'Please enter your message',
        'zh' => '请填写您的留言'
    )));
  }

  if (!empty($messages)) {
    Message::register($messages);
    HTML::forwardBackToReferer();
  }

  // check spam
  if (module_enabled('form') && !Form::checkSpamToken('global contact form')) {
    $message = new Message(Message::DANGER, i18n(array(
        'en' => 'Form login session expired. Please try again',
        'zh' => '表单提交时限过期，请重新尝试登录'
    )));
    Message::register($message);
    HTML::forwardBackToReferer();
  }

  /** success action **/
  Message::register(new Message(Message::SUCCESS, i18n(array(
      'en' => 'Thank you for your contact ;) We will get back to you soon.',
      'zh' => '感谢您的留言 ;) 我们会及时和您沟通'
  ))));
  
  if (module_enabled('mail')) {
    $message = array();
    foreach ($_POST['contact'] as $key => $val) {
      $message[] = "<p><strong>$key</strong>:<br />".str_replace("\n", "<br />", $val)."</p><br />";
    }
    $message = implode("\n", $message);
    sendemailAdmin('Site contact form', $message);
  }
  HTML::forwardBackToReferer();
}





/*** render form if no overids ***/

// override this call if "site" module has the override controller
$override_controller = MODULESROOT . '/site/controllers/form/contact.php';
if (is_file($override_controller)) {
  require $override_controller;
  exit;
}

$html = new HTML();

$html->renderOut('core/backend/html_header', array('title' => i18n(array(
    'en' => 'Contact',
    'zh' => '联系'
))));
echo Form::renderContactForm();echo "<a href='".uri('users')."'>users</a>";
$html->renderOut('core/backend/html_footer');

exit;