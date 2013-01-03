<?php
namespace AffiliateWindow;

/**
 * A custom error object for handling SoapFaults
 */
class SoapError
{
    public $sCode = '';
    public $sString = '';
    public $sDetails = '';

    /**
     * @param object $oSoapFault
     * @param string $sFunctionName
     * 
     * @return SoapError
     */
    function SoapError($oSoapFault, $sFunctionName)
    {
        if (!empty($oSoapFault)) {
            $this->sCode = $oSoapFault->faultcode;
            $this->sString = $oSoapFault->faultstring;
            $errorDetail = !empty($oSoapFault->detail) 
                         ? $oSoapFault->detail->ApiException->message : 'No error message available';
            $this->sDetails = $sFunctionName . ': ' . $errorDetail;
        }
    }
}