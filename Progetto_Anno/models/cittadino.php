<?php
// TODO: Da rimuovere nel deploy ----------------------------------------------------
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 

//require_once ("../inc/sanitize.inc");

class Cittadini
{
    private $connesione;

    private $nome_tabella = "cittadini";

    //Attributi
    public $ID_cittadini;
    public $nome;
    public $cognome;
    public $email;
    public $telefono;


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
		// Primo parametro valore da ripulire, Secondo parametro connessione al DB, Terzo parametro per rimuovere TAG HTML
		$this->nome = sanitize($this->nome, $this->connesione, true);
		$this->cognome = sanitize($this->cognome, $this->connesione, true);
		$this->email = sanitize($this->email, $this->connesione, true);
		$this->telefono = sanitize($this->telefono, $this->connesione, true);
		
		$nome = '%'.$this->nome.'%';
		$cognome = '%'.$this->cognome.'%';
		$email = '%'.$this->email.'%';
        $telefono = '%'.$this->telefono.'%';

		$query = "SELECT * FROM " . $this->nome_tabella . " AS a; "; // select all

		$stmt = $this->connesione->prepare($query);
		//$stmt->bind_param("sss", $isbn, $titolo, $autore);
		if ($stmt->execute() === TRUE) 	// execute query
			$res = $stmt->get_result(); // restituzione dei risultati
		$stmt->close(); 	// chiude statement
	}
	// --- CREARE OGGETTO ---
	function create()
	{
		$query = "INSERT INTO " . $this->nome_tabella . " (nome,cognome,email,telefono) VALUES (?, ?, ?,?)";

		$stmt = $this->connesione->prepare($query);
		
		// Funzioni x sanitizzare (sanitize) i dati
		// Primo parametro valore da ripulire, Secondo parametro connessione al DB, Terzo parametro per rimuovere TAG HTML
		$this->nome = sanitize($this->nome, $this->connesione, true);
		$this->cognome = sanitize($this->cognome, $this->connesione, true);
		$this->email = sanitize($this->email, $this->connesione, true);
		$this->telefono = sanitize($this->telefono, $this->connesione, true);
		
		// binding (tipi di bind  i = int, d = float, s = string, b = blob)
		$stmt->bind_param("sssi", $this->nome, $this->cognome, $this->email,  $this->telefono);
		
		// execute query
		if($stmt->execute()){
			$this->ID_cittadini = $this->connesione->insert_id;
			return true;
		}
		
		return false;
	}
	
	// --- AGGIORNARE OGGETTO ---
	function update()
	{
		$query = "UPDATE " . $this->nome_tabella . " SET nome = ?, cognome = ?, email = ?, telefono = ?,WHERE ID_cittadini = ?";
		
		$stmt = $this->connesione->prepare($query);
		
		// sanitize
		$this->nome = sanitize($this->nome, $this->connesione, true);
		$this->cognome = sanitize($this->cognome, $this->connesione, true);
		$this->email = sanitize($this->email, $this->connesione, true);
		$this->telefono = sanitize($this->telefono, $this->connesione, true);
		$this->ID_cittadini = sanitize($this->ID_cittadini, $this->connesione, true);
		
		// binding (tipi di bind  i = int, d = float, s = string, b = blob)
		$stmt->bind_param("sssii", $this->nome, $this->cognome, $this->email, $this->telefono, $this->ID_cittadini);
				
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
		$query = "DELETE FROM " . $this->nome_tabella . " WHERE ID_cittadini = ?";
		
		$stmt = $this->connesione->prepare($query);
		
		// sanitize
		$this->ID_cittadini = sanitize($this->ID_cittadini, $this->connesione, true);
		
		// binding (tipi di bind  i = int, d = float, s = string, b = blob)
		$stmt->bind_param("i", $this->ID_cittadini);
		
		// execute query
		if($stmt->execute()){ 
			return true; // anche se non ha cancellato nulla perchè non ha trovato la chiave
		}
		
		return false;
	}
}
?>