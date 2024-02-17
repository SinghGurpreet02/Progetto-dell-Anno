<!DOCTYPE html>
<head>  
<link rel="stylesheet" href="style.css">

        <?php //inclusioni di file esterni
            include("connessione.php");


            function Visualizza($f_conn, $f_switch){ //estrae da "operatori" o "cittadini"
                // --->  a seconda della variabile $f_switch  --->  cambiata dal radiobutton"scelta"
                $sql="SELECT * FROM ".$f_switch.""; 
                
                $res = $f_conn->query($sql);

                return $res;
            }

        ?>

    <title>Interfaccia</title>
</head>
<body>

    <nav>
        <a href="#">Home</a>
        <a href="#">Ricerca</a>
    </nav>

    <!-- mettere per ogni div, l'elemento da destra a sinistra (1-checkbox, 2-tabella, 3-filtri) -->
    <div class="container">
    <div class="divider divider-1"></div>
    <div class="divider divider-2"></div>
    <table>
        <div>
        <?php //stampa campi tabella inziali e dati rispettivi
            echo"<tr>
            <th>Seleziona</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Email</th>
            <th>Telefono</th>
            </tr>";
        ?>
        </div>
        <div>
            <?php //stampa caselle di modalità di ricerca
                
            ?>    
        </div>

        <thead>
            
        </thead>
        
        <tbody>
            <tr>   
                <td><input type="checkbox"></td>
                <td>Mario</td>
                <td>Rossi</td>
                <td>mario.rossi@gmail.com</td>
                <td>3315409674</td>
            </tr>

        </tbody>
    </table>

    <div class="divider divider-3"></div>
    </div>                           
</body>
</html>
