<?php
/* --- INSERT DI UN NUOVO OGGETTO ---

Posso richiamare questo servizio soltanto da Postman perchè devo inviare un JSON con l'oggetto da inserire
1. impostare il metodo HTTP POST
2. immettere l'URL della richiesta
3. selezionare il body per immettere i dati del operatori$operatori
4. selezionare raw
5. inserire il JSON seguente:
{
    "ISBN" : "00000020dd02",
    "cognome" : "Kafka sulla spiaggia",
    "nome" : "Murakami Haruki",
	"Prezzo" : 3.5
}

Specifico il metodo POST!
Una richiesta POST viene infatti utilizzata quando si ha la necessità di 
inviare al server alcune informazioni aggiuntive all'interno del suo body. 
Le informazioni aggiuntive da inviare al nostro server saranno, ovviamente, 
i dati del operatori$operatori che vorremmo inserire.
*/

// TODO: Utili in fase di debug, da rimuovere nel deploy
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); 
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

// file_get_contents: permette di recuperare il contenuto da file locali o URL e memorizzarli in una stringa
// json_decode: riceve una stringa codificata in formato JSON e la converte in una variabile PHP
// Takes raw data from the request
$date = json_decode(file_get_contents("php://input")); // In alternativa si potrebbe utilizzare $oggetto = JsonParser($temp->object,$operatori);


if(
	!empty($date->nome) &&
	!empty($date->cognome) &&
	!empty($date->id_corpo)
){
	$operatori = new Operatori($db);
	
	$operatori->nome = $date->nome;			// ATTENZIONE a maiuscole
	$operatori->cognome = $date->cognome;
	$operatori->id_corpo = $date->id_corpo;
	
	if($operatori->create()){
		http_response_code(201); // Created (https://it.wikipedia.org/wiki/Codici_di_stato_HTTP)
		$rspMsg = new Responsemessage("operatore creato correttamente", $operatori->ID_operatore);
	} else {
		http_response_code(503); //503 servizio non disponibile
		$rspMsg = new Responsemessage("Impossibile creare l'operatore", -1);
	}
	
} else {
	http_response_code(400); //400 bad request
	$rspMsg = new Responsemessage("Impossibile creare l'operatore i dati sono incompleti", -1);
}

echo json_encode($rspMsg); // in alternativa echo json_encode(array("message" => "Testo del messaggio"));
?>