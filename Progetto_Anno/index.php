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
      if ($data_cittadino == false || $data_operatore == false) {
        echo "Errore durante la chiamata al web service";
      }  

      function Read($value)
      {
        if($value==1){ 
            $response = file_get_contents("http://localhost/operatori/read.php");
            $data = json_decode($response, true);    
        }
        else if($value==2){
            $response = file_get_contents("http://localhost/cittadini/read.php");
            $data = json_decode($response, true);
        }
      }

?>

<!DOCTYPE html>
<head>  
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/script.js"></script>

    <script>
            function VisualizzaUtenza() {
            var selectBox = document.getElementById("utenza");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            
            if (selectedValue == "1") { //operatori
                Read(selectedValue);
                Visualizzazione($data);
            } else if (selectedValue == "2") { //cittadini
                Read(selectedValue);
                Visualizzazione($data);
            }
        }
</script>


    <?php //inclusioni di file esterni
        include("connessione.php");

        function mostraAlertHTML() {
            echo "<script>alert();</script>";
        }
    ?>

    <title>Interfaccia</title>
</head>
<body action="Ricerca.php" method="$POST">
    <nav class="nav">
        <a href="#" onclick=alert()>Home</a> <!-- aggiornare  -->
        <a href="#">Ricerca</a> <!-- aggiornare  -->
    </nav>
        <?php
            
            echo"<label for='Ricerca'>Mostra i dati degli:</label> 
            <select id='utenza' name='utenza' style='height: 30px' onchange='VisualizzaUtenza()'> 
                <option value='1'>Operatori</option> 
                <option value='2'>Cittadini</option>    
            </select>";
    

            /*-------------------------------------------- cambio dinamico dato da <select> sopra, ajax funziona, -----------------------
            if(isset($_POST['aggiorna'])) {
                mostraAlertHTML();
                $action = $_POST['aggiorna'];
                if($action=='Operatori' || $action=='Cittadini'){
                    echo"<button>piseelonero</button>";
                    $param = $_POST['param'];
                    
                    Visualizza($param);
                }
            }
            */
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
        <div class="table-container">
        
        <?php //stampa campi tabella inziali e dati rispettivi
        function Visualizzazione($data){
            $fields=[];
            if(isset($data->id_corpo)){ //caso dati operatori
                $fileds=['ID_operatore', 'nome', 'cognome', 'id_corpo', 'tipologia_utente', 'username', 'password', 'token'];
            }
            else{ //caso dati cittadini
                $fileds=['ID_cittadino', 'nome', 'cognome', 'email', 'telefono'];
            }
                
                echo "<table id='visualizzazione'>
                <tr>";
                foreach($fields as $field){
                    echo"<th>".$field."</th>";
                }
                echo "</tr>";
                
                echo"<tr>
                <td class='nocontorno'><input type='checkbox'></td>";
                foreach($data as $obj){
                    foreach($fields as $field){
                    echo"<td>".$obj[$field]."</td>";
                    }
                }
                echo"</tr>";

                /*
            foreach($data as $operatore){
                echo"<tr>
                <td class='nocontorno'><input type='checkbox'></td>
                <td>".$operatore['ID_operatore']."</td>
                <td>".$operatore['nome']."</td>
                <td>".$operatore['cognome']."</td>
                <td>".$operatore['id_corpo']."</td>
                <td>".$operatore['tipologia_utente']."</td>
                <td>".$operatore['username_operatore']."</td>
                <td>".$operatore['password_operatore']."</td>
                <td>".$operatore['token']."</td>
            </tr>
            ";
            }
            else{ //caso dati cittadini
                echo "<table id='tabella-cittadini'>
                <tr>
                <th class='nocontorno'></th>
                <th>ID</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>Telefono</th>
            </tr>
            ";
            
            foreach($data_cittadino as $cittadino){
                echo"<tr>
                <td class='nocontorno'><input type='checkbox'></td>
                <td>".$cittadino['ID_cittadino']."</td>
                <td>".$cittadino['nome']."</td>
                <td>".$cittadino['cognome']."</td>
                <td>".$cittadino['email']."</td>
                <td>".$cittadino['telefono']."</td>
            </tr>
            ";
            }
            }
        */
        }
 




        

    ?>       

        </div>
    </div>

        


    <?php
    // ricerca
    $ricerca ="";
        
    
    ?>

    </body>
</html>
