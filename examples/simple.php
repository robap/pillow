<?php

include __DIR__ . '/../lib/Autoloader.php';
include __DIR__ . '/config.php';

use Pillow\Service;
use Pillow\HttpClient;

$s = new Service($zpid);
$results = $s->getSearchResults('2114 Bigelow Ave', '98109');
$property = $results->current();

"Results:" . PHP_EOL;
echo "zpid      : " . $property->zpid . PHP_EOL;
echo "city      : " . $property->city . PHP_EOL;
echo "details   : " . $property->links->homedetails . PHP_EOL;
echo "lat       : " . $property->latitude . PHP_EOL;
echo "lon       : " . $property->longitude . PHP_EOL;
echo "zestimate : " . $property->zestimate->amount . PHP_EOL;
echo "updated   : " . $property->zestimate->lastUpdated . PHP_EOL;
echo "low       : " . $property->zestimate->range->low . PHP_EOL;
echo "high      : " . $property->zestimate->range->high . PHP_EOL;