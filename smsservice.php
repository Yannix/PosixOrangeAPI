<?php
include_once 'smsitem.php';

class SMSService
{
	CONST ORANGE_URL = '';
	
	protected $description = 'POSIX Inc. sample charge';
	protected $currency = 'XOF';
	protected $ReferenceSuffixe = 'REF';
	
	static function send2API( $content, $APIauthorization )
	{
		
		$options = array('http' =>
			array(
				'method'  => 	"POST",
				'header'  => 	"Content-type: application/json\r\n".
								"Authorization: ".$APIauthorization,
				'content' => 	$content
			)
		);

		$context = stream_context_create( $options );
		
		$result = file_get_contents( ORANGE_URL, false, $context );
		
		if( strpos( $http_response_header[0], '201 Created' ) !== false )
		{
			$result = json_decode( $result );
			return $result;
		}
		
		return null;
	}
	
	
	static function sendSMS( SMSItem $sms, $APIauthorization = null )
	{
		
		$result = SMSService::send2API( $sms->serialize(), $APIauthorization );
		
		return $result;
	}
	
	
	static function ChargeCustomer( $msisdn, $chargeAmount, $chargeID, $appID, $reference, $description = null, $currency = null )
	{
		$chargingInfo = array( 	'description' => $description,
								'amount' => $chargeAmount,
								'currency' => $currency
								);
								
		$chargingMetadata = array( 	'serviceID' => '',
									'productID' => '' );
		
		$info = array( 	'address' => 'tel:'.$msisdn,
						'transactionOperationStatus' => 'Charged',
						'chargingInformation' => $chargingInfo,
						'chargingMetadata' => $chargingMetadata,
						'referenceCode' => $this->ReferenceSuffixe . '-'. $reference,
						'clientCorrelator' => $reference )
		
		$content = json_encode( $info );
		
		$result = SMSService::send2API( $sms->serialize() );
		
		return $result
	}

}


?>