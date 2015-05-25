<?php
require_once __DIR__ . '/../../../bootstrap.php';

$result = file_get_contents("https://partner-int-api.groupon.com/deals.json?country_code=AU&tsToken=IE_AFF_0_".$settings['groupon']['api']['affiliate_id']."_212556_0&division_id=national-deal&offset=0&limit=20");

echo $result;