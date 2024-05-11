<?php
/* --- DELETE DI UN OGGETTO ESISTENTE ---

Posso richiamare questo servizio soltanto da Postman:
1. impostare il metodo HTTP DELETE
2. immettere l'URL della richiesta aggiungendo ?isbn=x
*/

// TODO: Utili in fase di debug, da rimuovere nel deploy
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../inc/database.inc.php");
require_once("../models/cittadino.php");
require_once("../inc/sanitize.inc.php");
require_once("../inc/responsemessage.inc.php");
require_once("../inc/tokenvalidator.inc.php"); // OPZIONALE per rispondere solo ad utenti autenticati con token

$database = new Database();
$db = $database->getConnection();

// Il Tokenvalidator è necessario solo quando il servizio risponde ad utenti autenticati 
if($database->GetAuthenticated() && !Tokenvalidator($conn,$user)){
	http_response_code(401);
	exit;
}

if(isset($_GET['ID_cittadino'])) // Recupero l'ID_cittadini dalla querystring
{
	$cittadini = new Cittadini($db);
	$cittadini->ID_cittadino = $_GET['ID_cittadino'];

	if($cittadini->delete()){
		http_response_code(200); // OK (https://it.wikipedia.org/wiki/Codici_di_stato_HTTP)
		$rspMsg = new Responsemessage("cittadino eliminato correttamente", $cittadini->ID_cittadino); 
	} else {
		http_response_code(503); //503 service unavailable
		$rspMsg = new Responsemessage("Impossibile eliminare il cittadino", -1); 
	}
} else {
	http_response_code(503); //503 service unavailable
	$rspMsg = new Responsemessage("ID_cittadino non indicato", -1); 
}

echo json_encode($rspMsg); // in alternativa echo json_encode(array("message" => "Testo del messaggio"));
?>