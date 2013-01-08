<?php
namespace AffiliateWindow;

/**
 * ProductServe
 */
class AwSoapClient extends AbstractPhp5Client
{
    const WSDL = 'http://api.productserve.com/v2/ProductServeService?wsdl';
    const API_NAMESPACE = 'http://api.affiliatewindow.com/';

    function __construct(
        $apiUsername = null, $apiPassword = null, $apiUserType = null
    ) {
        // create user object
        $oUser = new \stdClass();

        // IF api key is used, add only that to user object
       
        $oUser->iId = $apiUsername;
        $oUser->sPassword = $apiPassword;
        $oUser->sType = $apiUserType;
        
        parent::__construct(
            self::WSDL, 
            self::API_NAMESPACE,
            $oUser
        );
    }
}
