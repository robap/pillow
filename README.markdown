# Pillow - PHP client for the Zillow API

This library provides a PHP interface for the Zillow API
(see: http://www.zillow.com/howto/api/APIOverview.htm)

## Requirements

* PHP >= 5.2
* PHP CURL extension

## Examples

### Basic Use
<pre>
    require '/path/to/pillow/lib/pillow.php';

    $pf = new Pillow_Factory( 'your zws id provided by Zillow' );

    try {
        //$search will be an array with 1 or more Pillow_Property objects. Exact 
        // matches will be found at $search[0]
        $search = $pf->findDeepProperties( 'some address', 'city state or zip' );
    } catch (Exception $e) {
        //Your code to handle exceptions
    }
</pre>

### Get a Zillow Zestimate
<pre>
    require '/path/to/pillow/lib/pillow.php';

    $pf = new Pillow_Factory( 'your zws id provided by Zillow' );

    try {
        $search = $pf->findDeepProperties( 'some address', 'city state or zip' );
    } catch (Exception $e) {
        //Your code to handle exceptions
    }

    try {
        $z = $search[0]->getZestimate();
        echo "zestimate value: ", $z->amount;
    } catch (Pillow_NoZestimateAvailableException $e) {
        //Your code to handle exceptions
    } catch (Exception $e) {
        //Your code to handle exceptions
    }
</pre>

### Get a Zillow Chart url
<pre>
    require '/path/to/pillow/lib/pillow.php';

    $pf = new Pillow_Factory( 'your zws id provided by Zillow' );

    try {
        $search = $pf->findDeepProperties( 'some address', 'city state or zip' );
    } catch (Exception $e) {
        //Your code to handle exceptions
    }

    try {
        $chart = $search[0]->getChart( Pillow_Property::CHART_UNIT_DOLLAR );
        echo "chart url: ", $chart->url, "\n";
    } catch (Exception $e) {
        //Your code to handle exceptions
    }
</pre>

## About Exceptions
The Zillow API can return quite a few different error codes. This php library
will throw an appropriate Pillow_* exception for each of these. There are alot
(see lib/pillow/Transporter.php). You can choose to handle each of these
with try...catch and gain maximum flexibility. But, because they all inherit
php's Exception class, you can catch just the Exception. This will make your
code simpler.