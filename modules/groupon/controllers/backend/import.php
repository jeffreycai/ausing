<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// craw groupon homepage and get deal links
load_library_simple_html_dom();
$dom = file_get_html('http://www.groupon.com.au/deals/sydney-premium');
$ds = array();
foreach ($dom->find('a.extraDealMulti') as $a) {
  $deal = new stdClass();
  $deal->title = $a->find('.extraDealTxt',0)->innertext;
  $deal->price = $a->find('.price',0)->innertext;
  $deal->img = $a->find('img.extraDealImage',0)->{"data-original"};
  $deal->url = "http://www.groupon.com.au".$a->href;
  $ds[] = $deal;
}

$deals = array();
for ($i = 0; $i < sizeof($ds); $i++) {
  if (Deal::findbyOriginalUrlInValid($ds[$i]->url)) {
    continue;
  } else {
    $deals[] = $ds[$i];
  }
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


//http://t.groupon.com.au/r?tsToken=AU_AFF_0_200615_281057_0&url=http%3A%2F%2Fwww.groupon.com.au%2Fdeals%2Fsydney-premium%2Fthe-lemon-tree-3%2F720307983%3FCID%3DAU_AFF_5600_225_5383_1%26nlp%26utm_medium%3Dafl%26utm_source%3DGPN%26utm_campaign%3D200615%26mediaId%3D281057