<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Pillow_Transporter
{
    /**
     * Curl resource ID
     * @var string
     */
    private $_conn;

    /**
     * Class constructor
     * @access public
     */
    public function __construct( )
    {
        $this->_conn = curl_init();

        curl_setopt( $this->_conn, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt( $this->_conn, CURLOPT_USERAGENT, 'pillow' );
    }

    /**
     * Class destructor
     */
    public function __destruct()
    {
        curl_close( $this->_conn );
    }

    /**
     * Get the contents of the given url as simpleXMLObject. Any errors fetching
     * data will throw an exception.
     * @param string $uri
     * @param string $context - the context for exception handling (valid values:
     *                          'search', 'zestimate', 'chart')
     * @return simpleXMLObject (or void if exception thrown)
     * @throws Pillow_*Exception
     */
    public function get( $uri, $context )
    {
        curl_setopt( $this->_conn, CURLOPT_URL, $uri );
        curl_setopt( $this->_conn, CURLOPT_CUSTOMREQUEST, 'GET' );

        $result = curl_exec( $this->_conn );

        $http_code = (string) curl_getinfo( $this->_conn, CURLINFO_HTTP_CODE );

        $xml = simplexml_load_string( $result );

        if( FALSE === $xml )
        {
            $http_code = $this->_trans->getHttpStatusCode();
            throw new Pillow_ServerCommunicationError($http_code);
            return;
        }

        $text = (string) $xml->message->text;
        $code = (string) $xml->message->code;

        if( $code != '0' )
        {
            throw $this->generateException( $code, $text, $context, $xml );
            return;
        }
        else
        {
            return $xml;
        }
    }

    /**
     * Gets the status code from the last call to the get method
     * @return int
     */
    public function getHttpStatusCode()
    {
        return curl_getinfo($this->_conn, CURLINFO_HTTP_CODE);
    }

    /**
     * Generates an appropriate exception based on the code and context
     * @param string $code
     * @param string $text
     * @param string $context
     * @return Pillow_*Exception
     */
    private function generateException( $code, $text, $context, $xml )
    {
        switch( $code ) {
                case '1':
                    return new Pillow_ServerSideException($text, $code, $xml);
                case '2':
                    return new Pillow_InvalidZwisdException($text, $code, $xml);
                case '3':
                    return new Pillow_WebServicesUnavailableException($text, $code, $xml);
                case '4':
                    return new Pillow_ApiCallUnavailableException($text, $code, $xml);
                case '500':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_InvalidAddressException($text, $code, $xml);
                        case 'zestimate':
                        case 'chart':
                            return new Pillow_InvalidZpidException($text, $code, $xml);
                        default:
                            return new Pillow_UnknownException($text, $code, $xml);
                    }
                    
                case '501':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_InvalidCityStateZipException($text, $code, $xml);
                        case 'zestimate':
                            return new Pillow_RecordDoesNotCorrespondException($text, $code, $xml);
                        case 'chart':
                            return new Pillow_InvalidChartUnitTypeException($text, $code, $xml);
                        default:
                            return new Pillow_UnknownException($text, $code, $xml);
                    }

                case '502':
                    switch( $context ) {
                        case 'search':
                            throw new Pillow_NoResultsFoundException($text, $code, $xml);
                        case 'zestimate':
                            throw new Pillow_NoZestimateAvailableException($text, $code, $xml);
                        case 'chart':
                            throw new Pillow_InvalidChartWidthException($text, $code, $xml);
                        default:
                            return new Pillow_UnknownException($text, $code, $xml);
                    }
                case '503':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_CityStateZipResolutionException($text, $code, $xml);
                        case 'comp':
                            return new Pillow_NoCompsException($text, $code, $xml);
                        case 'chart':
                            return new Pillow_ChartHeightInvalid($text, $code, $xml);
                        default:
                            return new Pillow_UnknownException($text, $code, $xml);
                    }
                    
                case '504':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_NoCoverageException($text, $code, $xml);
                        case 'comp':
                            return new Pillow_NoCompsException($text, $code, $xml);
                        default:
                            return new Pillow_UnknownException($text, $code, $xml);
                    }
                case '505':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_TimoutException($text, $code, $xml);
                        default:
                            return new Pillow_UnknownException($text, $code, $xml);
                    }
                case '506':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_AddressTooLongException($text, $code, $xml);
                        default:
                            return new Pillow_UnknownException($text, $code, $xml);
                    }
                case '507':
                case '508': //Undocumented Code
                    switch( $context ) {
                        case 'search':
                            return new Pillow_NoExactMatchException($text, $code, $xml);
                        default:
                            return new Pillow_UnknownException($text, $code, $xml);
                    }
                default:
                    return new Pillow_UnkownServiceException($text, $code, $xml);
        }
    }
    
}

class Pillow_Exception extends Exception
{
    protected $fetched_xml;

    public function __construct( $text, $code, $xmlObj )
    {
        $this->fetched_xml = $xmlObj;
        parent::__construct($text, $code);
    }

    /**
     * Gets the xml returned by Zillow as SimpleXMLElement
     * @return SimpleXMLElement
     */
    public function getXmlObj()
    {
        return $this->fetched_xml;
    }
}

class Pillow_ServerCommunicationError extends Pillow_Exception{}
class Pillow_ServerSideException extends Pillow_Exception{}
class Pillow_InvalidZwisdException extends Pillow_Exception{}
class Pillow_WebServicesUnavailableException extends Pillow_Exception{}
class Pillow_ApiCallUnavailableException extends Pillow_Exception{}
class Pillow_InvalidAddressException extends Pillow_Exception{}
class Pillow_InvalidCityStateZipException extends Pillow_Exception{}
class Pillow_NoResultsFoundException extends Pillow_Exception{}
class Pillow_CityStateZipResolutionException extends Pillow_Exception{}
class Pillow_NoCoverageException extends Pillow_Exception{}
class Pillow_TimoutException extends Pillow_Exception{}
class Pillow_UnkownServiceException extends Pillow_Exception{}
class Pillow_UnknownException extends Pillow_Exception{}
class Pillow_InvalidZpidException extends Pillow_Exception{}
class Pillow_RecordDoesNotCorrespondException extends Pillow_Exception{}
class Pillow_InvalidChartUnitTypeException extends Pillow_Exception{}
class Pillow_InvalidChartWidthException extends Pillow_Exception{}
class Pillow_InvalidChartHeightException extends Pillow_Exception{}
class Pillow_NoZestimateAvailableException extends Pillow_Exception{}
class Pillow_NoCompsException extends Pillow_Exception{}
class Pillow_AddressTooLongException extends Pillow_Exception{}
class Pillow_NoExactMatchException extends Pillow_Exception{}
class Pillow_ChartHeightInvalid extends Pillow_Exception{}
