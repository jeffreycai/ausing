<?php

function load_library_phpmailer() {
  require_once WEBROOT . DS . 'modules' . DS . 'mail' . DS . 'includes' . DS . 'libraries' . DS . 'PHPMailer' . DS . 'PHPMailerAutoload.php';
}

function sendemailAdmin($subject, $msg) {
  $settings = Vars::getSettings();
  load_library_phpmailer();

  $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

  $mail->IsSMTP(); // telling the class to use SMTP

  try {
//    $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
    $mail->Mailer = $settings['mail']['admin']['mailer'];
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = $settings['mail']['admin']['SMTPSecure'];                 // sets the prefix to the servier
    $mail->Host       = $settings['mail']['admin']['host'];      // sets GMAIL as the SMTP server
    $mail->Port       = $settings['mail']['admin']['port'];                   // set the SMTP port for the GMAIL server
    $mail->Username   = $settings['mail']['admin']['username'];  // GMAIL username
    $mail->Password   = $settings['mail']['admin']['password'];            // GMAIL password
    $mail->AddReplyTo($settings['mail']['admin']['to']);
    $mail->AddAddress($settings['mail']['admin']['to']);
    $mail->SetFrom($settings['mail']['admin']['from'], $settings['mail']['admin']['nickname']);
    $mail->Subject = (ENV == 'prod' ? '' : 'DEV: ') . $subject;
    $mail->MsgHTML($msg);
    $mail->Send();
    
//    if (class_exists('Log')) {
//      $log = new Log('mail', Log::SUCCESS, 'Send email to admin');
//      $log->save();
//    }
  } catch (phpmailerException $e) {
    if (module_enabled('Log')) {
      $log = new Log('mail', Log::ERROR, 'Failed to send email: ' . $e->errorMessage());
      $log->save();
    }
  } catch (Exception $e) {
    if (module_enabled('Log')) {
      $log = new Log('mail', Log::ERROR, 'Failed to send email: ' . $e->getMessage());
      $log->save();
    }
  }
}

function sendmail($subject, $msg, $to) {
  $settings = Vars::getSettings();
  load_library_phpmailer();

  $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

  $mail->IsSMTP(); // telling the class to use SMTP

  try {
//    $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
    $mail->Mailer = $settings['mail']['general']['mailer'];
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = $settings['mail']['general']['SMTPSecure'];                 // sets the prefix to the servier
    $mail->Host       = $settings['mail']['general']['host'];      // sets GMAIL as the SMTP server
    $mail->Port       = $settings['mail']['general']['port'];                   // set the SMTP port for the GMAIL server
    $mail->Username   = $settings['mail']['general']['username'];  // GMAIL username
    $mail->Password   = $settings['mail']['general']['password'];            // GMAIL password
    $mail->AddReplyTo($settings['mail']['general']['reply_to']);
    $mail->AddAddress($to);
    $mail->SetFrom($settings['mail']['general']['from'], $settings['mail']['general']['from_nickname']);
    $mail->Subject = (ENV == 'prod' ? '' : 'DEV: ') . $subject;
    $mail->MsgHTML($msg);
    $mail->Send();
    
//    if (class_exists('Log')) {
//      $log = new Log('mail', Log::SUCCESS, 'Send email to admin');
//      $log->save();
//    }
  } catch (phpmailerException $e) {
    if (module_enabled('Log')) {
      $log = new Log('mail', Log::ERROR, 'Failed to send email: ' . $e->errorMessage());
      $log->save();
    }
  } catch (Exception $e) {
    if (module_enabled('Log')) {
      $log = new Log('mail', Log::ERROR, 'Failed to send email: ' . $e->getMessage());
      $log->save();
    }
  }
}