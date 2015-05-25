<?php
class Form {
  
  /**
   * print js to gerenate spam token
   * 
   * @param type $jquery_selector
   */
  public static function loadSpamToken($jquery_selector, $unique_id) {
    echo '
<script type="text/javascript">
jQuery(function($){
  $("'.$jquery_selector.' input[type=submit]").addClass("disabled");
  $.get("/' . get_sub_root() . 'form/spam/token/fetch?unique_id='.$unique_id.'", function(data) {
    var input = $("<input type=\'hidden\' name=\'"+data["key"]+"\' value=\'"+data["value"]+"\' />");
    $("'.$jquery_selector.'").append(input);
    $("'.$jquery_selector.' input[type=submit], '.$jquery_selector.' button[type=submit]").removeClass("disabled");
  }, "json");
});
</script>
';
  }
  
  /**
   * Generate a spam token and store in session
   */
  static function generateSpamToken($unique_id) {
    $token_key = get_random_string(8);
    $token_value = get_random_string(12);
    if (!isset($_SESSION['spam_tokens'])) {
      $_SESSION['spam_tokens'] = array();
    }
    // store the generated token in session
    $_SESSION['spam_tokens'][$unique_id] = array();
    $_SESSION['spam_tokens'][$unique_id]['key'] = $token_key;
    $_SESSION['spam_tokens'][$unique_id]['value'] = $token_value;
    
    return array('key' => $token_key, 'value' => $token_value);
  }
  
  static function checkSpamToken($unique_id) {
    $origin_token = isset($_SESSION['spam_tokens']) && isset($_SESSION['spam_tokens'][$unique_id]) ? $_SESSION['spam_tokens'][$unique_id] : null;
    if ($key = isset($origin_token['key']) ? $origin_token['key'] : false) {
      if (isset($_POST[$key]) && $_POST[$key] == $origin_token['value']) {
        return true;
      }
    }

    return false;
  }

  
  static function renderContactForm() {
    $mandatory_label = ' <span style="color: rgb(185,2,0); font-weight: bold;">*</span>';
    
    $rtn = Message::renderMessages() . '
<form role="form" action="" method="post" id="contact">
  <fieldset>
    <div class="form-group form-field-name">
      <label for="name">'.i18n(array('en' => 'Your name', 'zh' => '您的姓名')).$mandatory_label.'</label>
      <input class="form-control" name="contact[name]" id="name" autofocus required="">
    </div>
    <div class="form-group form-field-email">
      <label for="email">'.i18n(array('en' => 'E-mail', 'zh' => '电子邮箱')).$mandatory_label.'</label>
      <input class="form-control" type="email" name="contact[email]" id="email" required="">
    </div>
    <div class="form-group form-field-message">
      <label for="message">'.i18n(array('en' => 'Message', 'zh' => '留言')).$mandatory_label.'</label>
      <textarea id="message" name="contact[message]" rows="5" class="form-control" required=""></textarea>
    </div>
    <div class="form-group" id="form-field-notice"><small><i>
      '.$mandatory_label.i18n(array(
          'en' => ' indicates mandatory fields',
          'zh' => ' 标记为必填项'
      )).'
    </i></small></div>
    <input type="submit" name="submit" class="btn btn-success btn-block disabled" value="'.i18n(array('en' => 'Submit', 'zh' => '提交')).'" />
    '.Form::loadSpamToken('#contact', 'global contact form').'
  </fieldset>
</form>
';
    return $rtn;
  }
}