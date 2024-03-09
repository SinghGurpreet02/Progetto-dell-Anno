<!DOCTYPE html>
<head>  
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>

    <?php //inclusioni di file esterni
        include("connessione.php");

        function mostraAlertHTML() { //----------------------------------------------------------------------
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

    <?php
        
        echo" <label for='Ricerca'>Mostra i dati degli:</label> 
        <select id='utenza' name='utenza' style='height: 30px' onchange='VisualizzaUtenza()'> 
            <option value='1'>Operatori</option> 
            <option value='2'>Cittadini</option>    
        </select> ";
  

        //-------------------------------------------- cambio dinamico dato da <select> sopra, non funziona l'ajax nello script... -----------------------
        if(isset($_POST['action']) && !empty($_POST['action'])) {
            mostraAlertHTML();
            $action = $_POST['action'];
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
        <input type="text" class="ricerca" id="Ricerca"style="height: 25px">
        <br><br>
        <input type="button" class="ricerca" id= "cerca" value="Cerca" style="height: 25px">

    
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
        
</body>
</html>
