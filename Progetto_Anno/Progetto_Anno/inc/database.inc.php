<?php
/*
Classe con metodo pubblico per avere la connessione al DB
MySQLi Extension fornisce un'interfaccia con i database MySQL
*/

class Database
{
	// credenziali PIGINI
	//private $host = "localhost";
	//private $db_name = "biblioteca";
	//private $username = "";
	//private $password = "";			
	
	// credenziali AQUILANTI
	private $host = "localhost";
	private $db_name = "progetto_anno";
	private $username = "root";
	private $password = "root";	
	private $authenticated = false;	
	public $conn;
	
	// connessione al database
	public function GetConnection()
	{
		// crea connessione
		$this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

		// controlla connessione
		if ($this->conn->connect_error) {
			die("Errore connessione DB: " . $this->conn->connect_error);
		}
		// connessione stabilita
		return $this->conn;
	}
	
	public function GetAuthenticated()
	{
		return $this->authenticated;
	}
}
?>