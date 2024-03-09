<?php
error_reporting(E_ALL); // Da rimuovere nel deploy
/*
Costruzione del messaggio di risposta
*/
class Responsemessage
{
	public $message;
	public $ID; // Valori negativi ad indicare errori specifici

	// costruttore
	public function __construct($msg,$ID)
	{	
		$this->message = $msg;
		$this->ID = $ID;
	}
}