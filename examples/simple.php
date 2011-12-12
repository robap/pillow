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
echo "chart url : " . $property->chart->url . PHP_EOL;
echo "chart x   : " . $property->chart->width . PHP_EOL;
echo "chart y   : " . $property->chart->height . PHP_EOL;

echo PHP_EOL . "Comps:" . PHP_EOL;
foreach($property->comps as $i => $comp) {
  echo "\tcomp      : " . $i . PHP_EOL;
  echo "\tzpid      : " . $comp->zpid . PHP_EOL;
  echo "\tcity      : " . $comp->city . PHP_EOL;
  echo "\tdetails   : " . $comp->links->homedetails . PHP_EOL;
  echo "\tlat       : " . $comp->latitude . PHP_EOL;
  echo "\tlon       : " . $comp->longitude . PHP_EOL;
  echo "\tzestimate : " . $comp->zestimate->amount . PHP_EOL;
  echo "\tupdated   : " . $comp->zestimate->lastUpdated . PHP_EOL;
  echo "\tlow       : " . $comp->zestimate->range->low . PHP_EOL;
  echo "\thigh      : " . $comp->zestimate->range->high . PHP_EOL;
  echo PHP_EOL;
}

echo PHP_EOL;
echo memory_get_peak_usage(true) / 1000 / 1000 . ' Mb';
echo PHP_EOL;