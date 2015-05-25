<?php

$result = file_get_contents("https://partner-int-api.groupon.com/deals.json?country_code=AU&tsToken=IE_AFF_0_".$settings['groupon']['api']['affiliate_id']."_212556_0&division_id=national-deal&offset=0&limit=20");
if ($result === false) {
  Message::register(new Message(Message::DANGER, "Can not read Groupon API"));
} else {
  $deals = json_decode($result);
}



$html = new HTML();

$html->renderOut('core/backend/html_header', array('title' => i18n(array(
  'en' => 'Groupon',
  'zh' => 'Groupon',
  ))), true);
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('groupon/backend/import', array(
    'deals' => $deals,
), true);

$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;