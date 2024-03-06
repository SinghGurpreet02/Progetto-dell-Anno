<?php

function Tokenvalidator($conn,$credenziali)
{
    if(!isset($credenziali->Token) || $credenziali->Token == "")
        return false;

    $query = "SELECT tipologia
    FROM utenti
    WHERE email = :email AND token = :token ";

    $credenziali->Email = htmlspecialchars(strip_tags($credenziali->Email));
    $credenziali->Token = htmlspecialchars(strip_tags($credenziali->Token));

    $preparedQuery = $conn->prepare($query);

    $preparedQuery->bindParam(":email", $credenziali->Email);
    $preparedQuery->bindParam(":token", $credenziali->Token);

    $preparedQuery->execute();
/*echo $query;
echo "-".$credenziali->Email."-";
echo "-".$credenziali->Token."-";*/
    if($preparedQuery->rowCount() == 0)
        return false;
    else
        return true;
}

?>