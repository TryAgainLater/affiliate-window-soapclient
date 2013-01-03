<?php

$awPsClient = new \AffiliateWindow\ProductServeSoapClient('your AW api key');
$response = $awPsClient->getProductList(array(
    'sQuery' => 'IPhone 4',
    'iLimit' => 3
));

echo '<pre>';
$output= '';
$output.= $awPsClient->__getLastRequest();
$output.= $awPsClient->__getLastResponse();
$output= str_replace('><', ">\n<", $output);
print $output;
print_r($response);
echo '</pre>';
