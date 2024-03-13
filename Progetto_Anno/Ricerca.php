<?php
      // URL del web service per la lettura dei libri
      $url_cittadino = "http://localhost/Progetto_Anno/cittadini/read.php"; //uguale all'url verificato su POSTMAN
      $url_operatore = "http://localhost/Progetto_Anno/operatori/read.php";
      
      // Invio Richiesta al web service e salvataggio del risultato nella variabile $response 
      $response_cittadino = file_get_contents($url_cittadino);
      $response_operatore = file_get_contents($url_operatore);
      
      // Decodifica del JSON
      $data_cittadino = json_decode($response_cittadino, true);    
      $data_operatore= json_decode($response_operatore, true);
      
      // Controllo del successo della richiesta
      if ($data_cittadino === false || $data_operatore == false) {
        echo "Errore durante la chiamata al web service";
      }  
?>

<!DOCTYPE html>
<head>  
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/script.js"></script>


    <?php //inclusioni di file esterni
        include("connessione.php");

        function mostraAlertHTML() { //------------------------------------------------
            echo "<script>alert();</script>";
        }

        function Visualizza($utenza){ //estrae da "operatori" o "cittadini"
            // --->  a seconda della variabile $utenza  --->  cambiata dal radiobutton"scelta"
            if(isset($utenza))
            {echo"<button>pisello</button>";} //.--------------------------------------------------
        }

    ?>

    <title>Interfaccia</title>
</head>
<body action="Ricerca.php" method="$POST">
    <nav class="nav">
        <a href="#" onclick=alert()>Home</a> <!-- aggiornare  -->
        <a href="#">Ricerca</a> <!-- aggiornare  -->
    </nav>
    <div class="vertical-divider">
        <?php
            
            echo" <label for='Ricerca'>Mostra i dati degli:</label> 
            <select id='utenza' name='utenza' style='height: 30px' onchange='VisualizzaUtenza()'> 
                <option value='1'>Operatori</option> 
                <option value='2'>Cittadini</option>    
            </select> ";
    
            //-------------------------------------------- cambio dinamico dato da <select> sopra, ajax funziona, -----------------------
            if(isset($_POST['aggiorna'])) {
                mostraAlertHTML();
                $action = $_POST['aggiorna'];
                if($action=='Operatori' || $action=='Cittadini'){
                    echo"<button>piseelonero</button>";
                    $param = $_POST['param'];
                    
                    Visualizza($param);
                }
            }
        ?>
        <br><br>

            <label for="Ricerca">Ricerca Per:</label> 
                <select id="Operatori" name="Operatori" style="height: 30px"> 
                    <option value="1">Nome</option> 
                    <option value="2">Cognome</option>
                </select>
            <br><br>
            <input type="text" class="ricerca" id="Ricerca" style="height: 25px" value placeholder="Inserisci testo...">
            <br><br>
            <input type="button" class="ricerca" id= "cerca" value="Cerca" style="height: 25px">
    </div>

    <div class="vertical-divider">
    <table>
            <?php //stampa campi tabella inziali e dati rispettivi
                echo "
                <table>
                    <tr>
                        <th class='nocontorno'></th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th>Telefono</th>
                    </tr>;
                <tr>
                    <td class='nocontorno'><input type='checkbox'></td>
                    <td>Mario</td>
                    <td>Rossi</td>
                    <td>01/01/1990</td>
                    <td>ABC123456789</td>
                </tr>";
                ?>
        </table>
    </div>
</body>
</html>
