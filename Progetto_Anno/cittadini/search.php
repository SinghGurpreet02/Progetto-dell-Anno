<?php
/*
--- SELECT DI OGGETTO FILTRATI ---

Posso richiamare questo servizio soltanto da Postman:
1. impostare il metodo HTTP POST
2. immettere l'URL della richiesta
3. selezionare il body per immettere i filtri sul cittadini
4. selezionare raw
5. inserire il JSON seguente:
{
    "Titolo" : "conte",
    "Autore" : "mario"
}
*/

// TODO: Utili in fase di debug, da rimuovere nel deploy
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Sfrutto la funzione header() di PHP per specificare gli header HTTP della risposta
header("Access-Control-Allow-Origin: *"); // rendere accessibile la pagina read.php a qualsiasi dominio
header("Content-Type: application/json; charset=UTF-8"); // restituisce un contenuto di tipo JSON, codificato in UTF-8
header("Access-Control-Allow-Methods: GET"); // Non è necessario specificare il metodo GET perchè se non indicato viene preso di default

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

$cittadini = new Cittadini($db); 	// Passo la connessione alla classe cittadini

$data = json_decode(file_get_contents("php://input")); // Takes raw data from the request

$cittadini->nome = $data->nome;			// ATTENZIONE a maiuscole
$cittadini->cognome = $data->cognome;

if(!empty($data->nome))
{
	$cittadini->nome = $data->nome;	
	$result = $cittadini->search($data->nome);
}
if(!empty($data->cognome))
{
	$cittadini->cognome = $data->cognome;
	$result = $cittadini->search($data->cognome);
}
if($result === FALSE)
{
	http_response_code(204);
}


if($result->num_rows == 0){
    http_response_code(204);	// No content
    $rspMsg = new Responsemessage("Nessun cittadino trovato in progetto dell'anno", -1); 
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