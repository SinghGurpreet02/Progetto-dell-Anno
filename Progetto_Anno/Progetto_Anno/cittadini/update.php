<?php
/* --- UPDATE DI UN OGGETTO ESISTENTE ---

Posso richiamare questo servizio soltanto da Postman:
1. impostare il metodo HTTP PUT
2. immettere l'URL della richiesta
3. selezionare il body per immettere i dati del cittadini
4. selezionare raw
5. inserire il JSON seguente:
{
    "ISBN" : "00000020dd02",
    "Titolo" : "Kafka sulla battigia",
    "Autore" : "Murakami Haruki"
}
*/

// TODO: Utili in fase di debug, da rimuovere nel deploy
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../inc/database.inc.php");
require_once("../models/cittadino.php");
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

$data = json_decode(file_get_contents("php://input")); // In alternativa si potrebbe utilizzare $oggetto = JsonParser($temp->object,$cittadini);

$cittadini = new Cittadini($db); 	// Passo la connessione alla classe cittadini

$cittadini->ID_cittadino = $data->ID_cittadino; 	// TODO: aggiungere controlli sui campi obbligatori
var_dump($cittadini->ID_cittadino);
exit;
$cittadini->nome = $data->nome;						// ATTENZIONE a maiuscole
$cittadini->cognome = $data->cognome;
$cittadini->email = $data->email;
$cittadini->telefono = $data->telefono;



if($cittadini->update()){
	http_response_code(200); // OK (https://it.wikipedia.org/wiki/Codici_di_stato_HTTP)
	$rspMsg = new Responsemessage("cittadini aggiornato correttamente", $cittadini->ID_cittadino); 
} else {
	http_response_code(503); //503 service unavailable
	$rspMsg = new Responsemessage("Impossibile aggiornare il cittadini", -1); 
}

echo json_encode($rspMsg); // in alternativa echo json_encode(array("message" => "Testo del messaggio"));
?>
