<?php
$division = $vars[1];

$page = isset($_GET['page']) ? $_GET['page'] : 1;

//$divisions = json_decode(file_get_contents('http://api-asia.groupon.de/api/mobile/au/divisions'));
//_debug($divisions->divisions);

$result = file_get_contents("https://partner-int-api.groupon.com/deals.json?country_code=AU&tsToken=IE_AFF_0_".$settings['groupon']['api']['affiliate_id']."_212556_0&division_id=$division&offset=".(($page-1)*$settings['groupon']['per_page'])."&limit=".$settings['groupon']['per_page']);

$ds = array();
if ($result === false) {
  Message::register(new Message(Message::DANGER, "Can not read Groupon API"));
} else {
  $objects = json_decode($result);
  $ds = $objects->deals;
  foreach ($ds as $deal) {
    $url = $deal->dealUrl;
    $tokens = explode("url=", $url);
    $url = urldecode($tokens[1]);
    $tokens = explode("?", $url);
    $deal->url = $tokens[0];
    $ds[] = $deal;
  }
}

$deals = array();
for ($i = 0; $i < sizeof($ds); $i++) {
  if (Deal::findbyOriginalUrlInValid($ds[$i]->url)) {
    continue;
  } else {
    $deals[] = $ds[$i];
  }
}

$total_page = ceil($objects->pagination->count / $settings['groupon']['per_page']);

$html = new HTML();

$html->renderOut('core/backend/html_header', array('title' => i18n(array(
  'en' => 'Groupon',
  'zh' => 'Groupon',
  ))), true);
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('groupon/backend/import_division', array(
    'deals' => $deals,
    'pagination' => $html->render('core/components/pagination', array(
        'total' => $total_page,
        'page' => $page
    ))
), true);

$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;


//http://t.groupon.com.au/r?tsToken=AU_AFF_0_200615_281057_0&url=http%3A%2F%2Fwww.groupon.com.au%2Fdeals%2Fsydney-premium%2Fthe-lemon-tree-3%2F720307983%3FCID%3DAU_AFF_5600_225_5383_1%26nlp%26utm_medium%3Dafl%26utm_source%3DGPN%26utm_campaign%3D200615%26mediaId%3D281057