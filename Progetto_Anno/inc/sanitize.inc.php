<?php

function sanitize($valore, $conn=null, $rimuovitag=false)
{
	// strip_tags: rimuove i tag HTML e PHP dall’input passato
	if ($rimuovitag)
		$valore = strip_tags($valore);
	
	// htmlspecialchars: converte i caratteri speciali di HTML ad es.: "<" in "& lt;" 
	$valore = htmlspecialchars($valore);
	
	// real_escape_string: crea stringa SQL valida codificata con escape tenendo conto del set di caratteri della connessione
	if ($conn)
		$valore = $conn->real_escape_string($valore);

    return $valore;
}

?>