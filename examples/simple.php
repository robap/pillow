<?php

include __DIR__ . '/../lib/Autoloader.php';
include __DIR__ . '/config.php';

use Pillow\Service;
use Pillow\HttpClient;

$s = new Service($zpid);
$results = $s->getSearchResults('2114 Bigelow Ave', '98109');
$property = $results->current();

"Results:" . PHP_EOL;
echo "zpid   : " . $property->zpid . PHP_EOL;
echo "city   : " . $property->city . PHP_EOL;
echo "details: " . $property->links->homedetails . PHP_EOL;
echo "lat    : " . $property->latitude . PHP_EOL;
echo "lon    : " . $property->longitude . PHP_EOL;