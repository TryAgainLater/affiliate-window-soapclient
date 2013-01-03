<?php
namespace AffiliateWindow;

/**
 * ProductServe v3 SoapClient
 */
class ProductServeSoapClient extends AbstractPhp5Client
{
    const WSDL = 'http://v3.core.com.productserve.com/ProductServeService.wsdl';
    const API_NAMESPACE = 'http://api.productserve.com/';

    function __construct(
        $apiKey, 
        $apiUsername = null, $apiPassword = null, $apiUserType = null
    ) {
        // create user object
        $oUser = new \stdClass();

        // IF api key is used, add only that to user object
        if ($apiKey) {
            $oUser->sApiKey = $apiKey;
        } else {
            $oUser->iId = $apiUsername;
            $oUser->sPassword = $apiPassword;
            $oUser->sType = $apiUserType;
        }
        
        parent::__construct(
            self::WSDL, 
            self::API_NAMESPACE,
            $oUser
        );
    }
}