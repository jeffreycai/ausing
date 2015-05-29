<?php

$url = $_GET['url'];
$response = new stdClass();

// https://partner-int.groupon.com/bookmarklet/v1/create/campaign?callback=jsonpCallback&affiliateId=200615&dealUrl=http%3A%2F%2Fwww.groupon.com.au%2Fdeals%2Fsydney-premium%2Fthe-lemon-tree-3%2F720307983&_=1432772480134

$html = file_get_contents('https://partner-int.groupon.com/bookmarklet/v1/create/campaign?callback=jsonpCallback&affiliateId='.$settings['groupon']['api']['affiliate_id'].'&dealUrl='.urlencode($url));

if (strpos($html, 'jsonpCallback') != 0) {
  $response->status = 'failed';
  $response->error_msg = 'Failed when calling bookmark js';
  echo json_encode($response);
  exit;
} else {
  $html = str_replace('jsonpCallback', '', $html);
  $html = trim($html, ' ();');
  
  $object = json_decode($html);
  if (!is_object($object)) {
    $response->status = 'failed';
    $response->error_msg = 'jsonpCallback is not a json object';
    echo json_encode($response);
    exit;
  }
  
  $sniplet = html_entity_decode($object->sniplet);
  $matches = array();
  preg_match('/href="([^"]+)"/', $sniplet, $matches);
  if (isset($matches[1])) {
    $response->status = 'success';
    $response->affiliate_url = $matches[1];
    echo json_encode($response);
    exit;
  } else {
    $response->status = 'failed';
    $response->error_msg = 'Failed to get affiliate url from groupon callback json';
    echo json_encode($replacement);
    exit;
  }
}

/*
jsonpCallback({"sniplet":"&lt;a href=\"http://t.groupon.com.au/r?tsToken=AU_AFF_0_200615_281876_0&url
=http%3A%2F%2Fwww.groupon.com.au%2Fdeals%2Fsydney-premium%2Fthe-lemon-tree-3%2F720307983%3FCID%3DAU_AFF_5600_225_5383_1
%26nlp%26utm_medium%3Dafl%26utm_source%3DGPN%26utm_campaign%3D200615%26mediaId%3D281876\"&gt;http://www
.groupon.com.au/deals/sydney-premium/the-lemon-tree-3/720307983&lt;/a&gt;\r\n&lt;img src=\"http://partner-ts
.groupon.com.au/track/impression?tsToken=AU_AFF_0_200615_281876_0\" width=\"1\" height=\"1\" /&gt;","errors"
:[]});
 */

/*
http://t.groupon.com.au/r?tsToken=AU_AFF_0_200615_281895_0&url=http%3A%2F%2Fwww.groupon.com.au%2Fdeals%2Fsydney-premium%2Fthe-lemon-tree-3%2F720307983%3FCID%3DAU_AFF_5600_225_5383_1%26nlp%26utm_medium%3Dafl%26utm_source%3DGPN%26utm_campaign%3D200615%26mediaId%3D281895

http://t.groupon.com.au/r?tsToken=AU_AFF_0_200615_281896_0&url=http%3A%2F%2Fwww.groupon.com.au%2Fdeals%2Fsydney-premium%2Fthe-lemon-tree-3%2F720307983%3FCID%3DAU_AFF_5600_225_5383_1%26nlp%26utm_medium%3Dafl%26utm_source%3DGPN%26utm_campaign%3D200615%26mediaId%3D281896
 */
