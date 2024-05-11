<?php
// TODO: Da rimuovere nel deploy ----------------------------------------------------
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 

//require_once ("../inc/sanitize.inc");

class Operatori
{
    private $connesione;

    private $nome_tabella = "operatori";

    //Attributi
    public $ID_operatore;
    public $nome;
    public $cognome;
    public $id_corpo;
	public $tipologia_utente;
	public $username;
	public $password;
	

    //====METHODS====
	public function __construct($db)
	{
		$this->connesione = $db;
	}

    // --- LEGGERE OGGETTI ---
	function read()
	{
		if (empty($nome))
			$query = "SELECT * FROM " . $this->nome_tabella . " AS a; "; // select all
		else
			$query = "SELECT * FROM " . $this->nome_tabella . " AS a WHERE nome = '" . $nome . "';"; // select some (TODO: meglio se parametrica)

		$stmt = $this->connesione->prepare($query);
		if ($stmt->execute() === TRUE) 	// execute query
			$res = $stmt->get_result(); // restituzione dei risultati

		$stmt->close(); 	// chiude statement
		
		return $res;
	}

    function search() // Parametri facoltativi da sanitizzare
	{
		$query = "";

		if(!is_null($this->nome))
		{
			$this->nome = sanitize($this->nome, $this->connesione, true);
			$nome = '%'.$this->nome.'%';
			
			$query = "SELECT * FROM " . $this->nome_tabella . " WHERE nome LIKE '$nome'"; // Query di Selzione per nome
		}
		// Primo parametro valore da ripulire, Secondo parametro connessione al DB, Terzo parametro per rimuovere TAG HTML
		if(!is_null($this->cognome))
		{
			$this->cognome = sanitize($this->cognome, $this->connesione, true);
			$cognome = '%'.$this->cognome.'%';

			$query = "SELECT * FROM " . $this->nome_tabella . " WHERE cognome LIKE '$cognome'"; // Query di Selezione per cognome
		}

		$stmt = $this->connesione->prepare($query);
		if ($stmt->execute() === TRUE) 	// execute query
			{
				return $res = $stmt->get_result(); // restituzione dei risultati
			}
		$stmt->close(); 	// chiude statement
	}
	// --- CREARE OGGETTO ---
	function create()
	{
		$query = "INSERT INTO " . $this->nome_tabella . " (nome,cognome,id_corpo) VALUES (?, ?, ?)";

		$stmt = $this->connesione->prepare($query);
		
		// Funzioni x sanitizzare (sanitize) i dati
		// Primo parametro valore da ripulire, Secondo parametro connessione al DB, Terzo parametro per rimuovere TAG HTML
		$this->nome = sanitize($this->nome, $this->connesione, true);
		$this->cognome = sanitize($this->cognome, $this->connesione, true);
		$this->id_corpo = sanitize($this->id_corpo, $this->connesione, true);
		$this->tipologia_utente = sanitize($this->tipologia_utente, $this->connesione, true);
		$this->username = sanitize($this->username, $this->connesione, true);
		$this->password = sanitize($this->password, $this->connesione, true);

		// binding (tipi di bind  i = int, d = float, s = string, b = blob)
		$stmt->bind_param("ssiiss", $this->nome, $this->cognome, $this->id_corpo, $this->tipologia_utente, $this->username, $this->password);
		
		// execute query
		if($stmt->execute()){
			$this->ID_operatore = $this->connesione->insert_id;
			return true;
		}
		
		return false;
	}
	
	// --- AGGIORNARE OGGETTO ---
	function update()
	{
		$query = "UPDATE " . $this->nome_tabella . " SET nome = ?, cognome = ?, id_corpo = ? WHERE ID_operatore = ?";
		//var_dump($query);
		//exit;
		$stmt = $this->connesione->prepare($query);
		
		// sanitize
		$this->nome = sanitize($this->nome, $this->connesione, true);
		$this->cognome = sanitize($this->cognome, $this->connesione, true);
		$this->id_corpo = sanitize($this->id_corpo, $this->connesione, true);
		$this->tipologia_utente = sanitize($this->tipologia_utente, $this->connesione, true);
		$this->username = sanitize($this->username, $this->connesione, true);
		$this->password = sanitize($this->password, $this->connesione, true);
		$this->ID_operatore = sanitize($this->ID_operatore, $this->connesione, true);
		
		// binding (tipi di bind  i = int, d = float, s = string, b = blob)
		$stmt->bind_param("issiiss",$this->ID_operatore, $this->nome, $this->cognome, $this->id_corpo, $this->tipologia_utente, $this->username, $this->password);
		
				
		// execute the query
		if($stmt->execute()){
			return true; // anche se non ha aggiornato nulla perchè non ha trovato la chiave
		}
		
		return false;
	}
	
	// --- CANCELLARE OGGETTO ---
	function delete()
	{
		// Qui si usa il question mark placeholders binding (?)
		$query = "DELETE FROM " . $this->nome_tabella . " WHERE ID_operatore = ?";
		
		$stmt = $this->connesione->prepare($query);
		
		// sanitize
		$this->ID_operatore = sanitize($this->ID_operatore, $this->connesione, true);
		
		// binding (tipi di bind  i = int, d = float, s = string, b = blob)
		$stmt->bind_param("i", $this->ID_operatore);
		
		// execute query
		if($stmt->execute()){ 
			return true; // anche se non ha cancellato nulla perchè non ha trovato la chiave
		}
		
		return false;
	}
}
?>