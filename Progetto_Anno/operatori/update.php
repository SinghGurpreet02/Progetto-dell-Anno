<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../inc/database.inc.php");
require_once("../models/operatore.php");
require_once("../inc/sanitize.inc.php");
require_once("../inc/responsemessage.inc.php");
require_once("../inc/tokenvalidator.inc.php"); // OPZIONALE per rispondere solo ad utenti autenticati con token

$database = new Database();
$db = $database->getConnection();

// Il TokenValidator è necessario solo quando il servizio risponde ad utenti autenticati 
if($database->GetAuthenticated() && !Tokenvalidator($conn,$user)){
	http_response_code(401);
	exit;
}

$data = json_decode(file_get_contents("php://input")); // In alternativa si potrebbe utilizzare $oggetto = JsonParser($temp->object,$operatori);

$operatori = new Operatori($db); 	// Passo la connessione alla classe operatori

$operatori->ID_operatore = $data->ID_operatore; 	// TODO: aggiungere controlli sui campi obbligatori
$operatori->nome = $data->nome;						// ATTENZIONE a maiuscole
$operatori->cognome = $data->cognome;
$operatori->id_corpo = $data->id_corpo;
$operatori->tipologia_utente = $data->tipologia_utente;
$operatori->username = $data->username;
$operatori->password = $data->password;

if($operatori->update()){
	http_response_code(200); // OK (https://it.wikipedia.org/wiki/Codici_di_stato_HTTP)
	$rspMsg = new Responsemessage("operatore aggiornato correttamente", $operatori->ID_operatore); 
} else {
	http_response_code(503); //503 service unavailable
	$rspMsg = new Responsemessage("Impossibile aggiornare l'operatore", -1); 
}

echo json_encode($rspMsg);
?>
