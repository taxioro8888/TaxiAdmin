<?php
	session_start();
	require_once("lib/autoload.php");
	if(file_exists(__DIR__."/../.env")){
		$dotenv = new Dotenv\Dotenv(__DIR__."/../");
		$dotenv->load();
	}
	
	Braintree_Configuration::environment('sandbox');
	Braintree_Configuration::merchantId('YOUR_MERCHANT_ID_HERE');
	Braintree_Configuration::publicKey('YOUR_PUBLIC_KEY_HERE');
	Braintree_Configuration::privateKey('YOUR_PRIVATE_KEY_HERE');
?>