<?php
Class SMSItem 
implements Serializable
{
	CONST MAX_LEN = 80;
	
	public __construct( $message, $msisdn, $sender = null )
	{
		$this->message = $message;
		$this->msisdn = $msisdn;
		$this->sender = $sender;
	}
	
	public function getMSISDN()
	{
		return $this->msisdn;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	
	public function getNormalizedMessage()
	{
		$normalized = trim( $this->message );
		$normalized = substr( $normalized, 0, MAX_LEN );
		
		return $normalized;
	}
	
	
	public function getSender()
	{
		return $this->sender;
	}
		
	public function setMSISDN( $msisdn )
	{
		$this->msisdn = $msisdn;
		return $this;
	}
	
	public function setMessage( $message )
	{
		$this->message = $message;
		return $this;
	}
	
	
	public function getSender( $sender )
	{
		$this->sender = $sender;
	}
	
	public function getData()
    {
        return array( 	'address' => 'tel:'. $this->msisdn,
						'SenderName' => $this->sender,
						'message' => $this->getNormalizedMessage() );
    }
	
	public function setData( array $data )
    {
		if( ! ( array_key_exists( 'tel' ) 
				&& array_key_exists( 'message' ) ) )
			return false;
		
		$this->msisdn = $data['tel'];
		$this->message = $data['message'];
		$this->sender = null;
		
		if(  array_key_exists( 'SenderName' ) )
			$this->sender = $data['SenderName'];
			
		return $this;
    }
	
	
	public function __toString()
    {
        return $this->getNormalizedMessage();
    }
	
	public function serialize()
    {
        return json_encode( $this->getData() );
    }
	
	public function unserialize( $data )
    {
        $data = json_decode( $data, true );
        $this->setData( $data );
    }
	
	protected $message;
	protected $msisdn;
	protected $sender;
}

?>