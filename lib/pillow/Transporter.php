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
            throw $this->generateException( $code, $text, $context );
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
    private function generateException( $code, $text, $context )
    {
        switch( $code ) {
                case '1':
                    return new Pillow_ServerSideException($text, $code);
                case '2':
                    return new Pillow_InvalidZwisdException($text, $code);
                case '3':
                    return new Pillow_WebServicesUnavailableException($text, $code);
                case '4':
                    return new Pillow_ApiCallUnavailableException($text, $code);
                case '500':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_InvalidAddressException($text, $code);
                        case 'zestimate':
                        case 'chart':
                            return new Pillow_InvalidZpidException($text, $code);
                        default:
                            return new Pillow_UnknownException($text, $code);
                    }
                    
                case '501':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_InvalidCityStateZipException($text, $code);
                        case 'zestimate':
                            return new Pillow_RecordDoesNotCorrespondException($text, $code);
                        case 'chart':
                            return new Pillow_InvalidChartUnitTypeException($text, $code);
                        default:
                            return new Pillow_UnknownException($text, $code);
                    }

                case '502':
                    switch( $context ) {
                        case 'search':
                            throw new Pillow_NoResultsFoundException($text, $code);
                        case 'zestimate':
                            throw new Pillow_NoZestimateAvailableException($text, $code);
                        case 'chart':
                            throw new Pillow_InvalidChartWidthException($text, $code);
                        default:
                            return new Pillow_UnknownException($text, $code);
                    }
                case '503':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_CityStateZipResolutionException($text, $code);
                        case 'comp':
                            return new Pillow_NoCompsException($text, $code);
                        default:
                            return new Pillow_UnknownException($text, $code);
                    }
                    
                case '504':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_NoCoverageException($text, $code);
                        case 'comp':
                            return new Pillow_NoCompsException($text, $code);
                        default:
                            return new Pillow_UnknownException($text, $code);
                    }
                case '505':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_TimoutException($text, $code);
                        default:
                            return new Pillow_UnknownException($text, $code);
                    }
                case '506':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_AddressTooLongException($text, $code);
                        default:
                            return new Pillow_UnknownException($text, $code);
                    }
                case '507':
                    switch( $context ) {
                        case 'search':
                            return new Pillow_NoExactMatchException($text, $code);
                        default:
                            return new Pillow_UnknownException($text, $code);
                    }
                default:
                    return new Pillow_UnkownServiceException($text, $code);
        }
    }
    
}

class Pillow_ServerCommunicationError extends Exception{}
class Pillow_ServerSideException extends Exception{}
class Pillow_InvalidZwisdException extends Exception{}
class Pillow_WebServicesUnavailableException extends Exception{}
class Pillow_ApiCallUnavailableException extends Exception{}
class Pillow_InvalidAddressException extends Exception{}
class Pillow_InvalidCityStateZipException extends Exception{}
class Pillow_NoResultsFoundException extends Exception{}
class Pillow_CityStateZipResolutionException extends Exception{}
class Pillow_NoCoverageException extends Exception{}
class Pillow_TimoutException extends Exception{}
class Pillow_UnkownServiceException extends Exception{}
class Pillow_UnknownException extends Exception{}
class Pillow_InvalidZpidException extends Exception{}
class Pillow_RecordDoesNotCorrespondException extends Exception{}
class Pillow_InvalidChartUnitTypeException extends Exception{}
class Pillow_InvalidChartWidthException extends Exception{}
class Pillow_InvalidChartHeightException extends Exception{}
class Pillow_NoZestimateAvailableException extends Exception{}
class Pillow_NoCompsException extends Exception{}
class Pillow_AddressTooLongException extends Exception{}
class Pillow_NoExactMatchException extends Exception{}
