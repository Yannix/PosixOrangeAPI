<?php

Class APICallBackChecker
{
	protected $data;
	
	function __construct()
	{
	
	}
	
	function getPOSTData()
	{
		$this->data = array();
		
		if( count( $_POST ) > 0 )
		{
			$this->data = json_decode( $_POST );
		}
		else
		{
			$this->data = json_decode( file_get_contents('php://input') );
		}
		
		return ( count( $this->data ) > 0 );
	}
	
	
	function get( $key )
	{
		if( isset( $data[$key] ) )
		{
			return $data[$key];
		}
		
		return null;
	}
}

?>