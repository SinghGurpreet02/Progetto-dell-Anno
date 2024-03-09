<?php
/* --- SELECT DI TUTTI GLI OGGETTI O DI UNO SPECIFICATO MEDIANTE CHIAVE ---

Posso richiamare questo servizio con un qls browser o da Postman:
http://localhost/webservice/cittadini/read.php
*/

// TODO: Utili in fase di debug, da rimuovere nel deploy
ini_set('display_errors', '1'); // Imposta il valore a 1 della direttiva display_errors e display_startup_errors che serve per mostrare o meno gli errori all'utente.
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);			// Funzione nativa che viene utilizzata per mostrare gli errori.

// Sfrutto la funzione header() di PHP per specificare gli header HTTP della risposta
header("Access-Control-Allow-Origin: *"); 					// Rende accessibile questa pagina a qualsiasi dominio 
header("Content-Type: application/json; charset=UTF-8"); 	// Indica che il formato del corpo della richiesta/risposta è JSON codificato in UTF-8
header("Access-Control-Allow-Methods: GET"); 				// Non è necessario specificare il metodo GET perchè se non indicato viene preso di default

require_once("../inc/database.inc.php");
require_once("../models/cittadino.php");
require_once("../inc/sanitize.inc.php");
require_once("../inc/responsemessage.inc.php");
require_once("../inc/tokenvalidator.inc.php"); // OPZIONALE per rispondere solo ad utenti autenticati con token

$database = new Database();
$db = $database->getConnection(); // Riferimento alla connessione

// Il TokenValator è necessario solo quando il servizio risponde ad utenti autenticati 
if($database->GetAuthenticated() && !Tokenvalidator($conn,$user)){
	http_response_code(401);
	exit;
}

$cittadini = new Cittadini($db); 	// Passo la connessione alla classe cittadini

if(isset($_GET['ID_cittadino']))	// Passare in GET (querystring) la chiave (se POST vedere file search.php)
	$result = $cittadini->read($_GET['ID_cittadino']);
else
	$result = $cittadini->read();

if($result->num_rows == 0){
    http_response_code(204);	// No content
    $rspMsg = new Responsemessage("Nessun cittadini trovato in Biblioteca", -1); 
	echo json_encode($rspMsg); 	// in alternativa echo json_encode(array("message" => "Testo del messaggio"));
    exit;
}

$items = array();

while($obj = $result->fetch_object()) {
	$item = array(
		"ID_cittadino" => $obj->ID_cittadino,
		"nome" => $obj->nome,
		"cognome" => $obj->cognome,
		"email" => $obj->email,
		"telefono" => $obj->telefono
	);
	
	array_push($items, $item); 	// Aggiungo al vettore 
}

http_response_code(200); 		// OK (https://it.wikipedia.org/wiki/Codici_di_stato_HTTP)
echo json_encode($items);

$result->free();	// al posto di unset
$db->close();		// chiusura e rilascio risorse
?>