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
        //$search will be an array with 0 or more Pillow_Property objects. Exact
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

    if( count($search) > 0 )
    {
        try {
            $z = $search[0]->getZestimate();
            echo "zestimate value: ", $z->amount;
        } catch (Pillow_NoZestimateAvailableException $e) {
            //Your code to handle exceptions
        } catch (Exception $e) {
            //Your code to handle exceptions
        }
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

    if( count($search) > 0 )
    {
        try {
            $chart = $search[0]->getChart( Pillow_Property::CHART_UNIT_DOLLAR );
            echo "chart url: ", $chart->url, "\n";
        } catch (Exception $e) {
            //Your code to handle exceptions
        }
    }
</pre>

### Get Comparables for a Property
<pre>
    require '/path/to/pillow/lib/pillow.php';

    $pf = new Pillow_Factory( 'your zws id provided by Zillow' );

    try {
        $search = $pf->findDeepProperties( 'some address', 'city state or zip' );
    } catch (Exception $e) {
        //Your code to handle exceptions
    }

    if( count($search) > 0 )
    {
        try {
            $comparables = $search[0]->getComps(2);
            echo "found comparables: ", count($comparables), "\n";
            $comp_zestimate_1 = $comparables[0]->getZestimate();
            $comp_zestimate_2 = $comparables[0]->getZestimate();
            echo "comp amount : ", $comp_zestimate_1->amount, "\n";
            echo "comp amount : ", $comp_zestimate_2->amount, "\n";
        } catch (Pillow_NoCompsException $e) {
            echo "no comps for this address\n";
        } catch (Exception $e) {
            print_r($e);
        }
    }
</pre>

## About Exceptions
The Zillow API can return quite a few different error codes. This php library
will throw an appropriate Pillow_* exception for each of these. There are alot
(see lib/pillow/Transporter.php). You can choose to handle each of these
with try...catch and gain maximum flexibility. But, because they all inherit
php's Exception class, you can catch just the Exception. This will make your
code simpler.

The exception objects contain useful information for debugging. For example:
$e->getCode(); //Actual status code returned by Zillow service
$e->getMessage(); //Actual message returned by Zillow service
$e->getXmlObject(); //The actual Zillow returned xml as a SimpleXMLElement object
print_r($e); //Dump the whole Exception object