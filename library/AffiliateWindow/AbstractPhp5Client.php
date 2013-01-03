<?php
namespace AffiliateWindow;

/**
 * PHP5: Extends SoapClient and automatically configures settings specific to the AWin API
 * http://wiki.affiliatewindow.com/index.php/ProductServe_API
 */
abstract class AbstractPhp5Client extends \SoapClient
{
    /**
     * Holds any errors produced during a SOAP request
     *
     * @var object
     */
    public $oSoapError = false;

    /**
     * @param string $wsdl
     * @param string $ns
     * @param object $oUser
     */
    public function __construct($wsdl, $ns, $oUser)
    {
        // create client
        parent::__construct($wsdl, array(
            'trace' => false, 
            'compression' => SOAP_COMPRESSION_ACCEPT 
                             | SOAP_COMPRESSION_GZIP 
                             | SOAP_COMPRESSION_DEFLATE
        ));

        // create headers
        $oHeader = new \SoapHeader($ns, 'UserAuthentication', $oUser, true, $ns);
        $aHeaders = array($oHeader);

        // getQuota only used on APIs which do not use a single API Key
        if (empty($oUser->sApiKey)) {
            $aHeaders[] = new \SoapHeader($ns, 'getQuota', true, true, $ns);
        }

        // set headers
        $this->__setSoapHeaders($aHeaders);

        // set WSDL caching
        ini_set("soap.wsdl_cache_enabled", 1);
        ini_set('soap.wsdl_cache_ttl', 86400);

        // set server response timeout
        ini_set('default_socket_timeout', 240);
    }

    /**
     * Executes the speficied function from the WSDL
     *
     * @copyright	DigitalWindow
     * @access 	public
     *
     * @param 	string 	$sFunctionName the name of the function to be executed
     * @param 	mixed 	$mParams [optional] the parameters to be passed to the function, can be array or single value
     *
     * @return 	mixed 	the results or a SoapError object
     */
    public function call($sFunctionName, $mParams = '')
    {
        // catch any exceptions
        try {
            return $this->$sFunctionName($mParams);
        } catch (\SoapFault $e) {
            $this->oSoapError = new SoapError($e, $sFunctionName);

            $error = $this->oSoapError;
        }

        return $error;
    }

    /**
     * Gives the remaining operations quota
     *
     * @copyright DigitalWindow
     * @access 	  public
     *
     * @return 	int - the remaining operations quota
     */
    public function getQuota()
    {
        $aMatches = array();
        $sResponse = $this->__getLastResponse();

        // use R.Exp. rather than XML parsers, as they might not be installed
        preg_match('/getQuotaResponse>(.*)<\/.*:getQuotaResponse>/', $sResponse, $aMatches);

        $iQuota = $aMatches[1];

        return $iQuota;
    }
}