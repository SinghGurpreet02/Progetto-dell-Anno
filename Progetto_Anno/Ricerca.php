<!DOCTYPE html>
<head>  
    <link rel="stylesheet" href="css/style.css">

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
<body action="Ricerca.php" method="$POST">
    <nav class="nav">
        <a href="#">Home</a>
        <a href="#">Ricerca</a>
    </nav>

    <?php
        echo" <label for='Ricerca'>Mostra i dati degli:</label> 
        <select id='Filtro' name='Filtro' style='height: 30px'> 
            <option value='1'>Operatori</option> 
            <option value='2'>Cittadini</option>    
        </select> ";
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

    
        <table class="tabel">
            <thead>
            <?php //stampa campi tabella inziali e dati rispettivi
                echo "
                <table>
                    <tr>
                        <th class='item-cerchiato'>Seleziona</th>
                        <th class='item-cerchiato'>Nome</th>
                        <th class='item-cerchiato'>Cognome</th>
                        <th class='item-cerchiato'>Email</th>
                        <th class='item-cerchiato'>Telefono</th>
                    </tr>";
            ?>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <th class='item-cerchiato'>Mario</td>
                    <td class='item-cerchiato'>Rossi</td>
                    <td class='item-cerchiato'>01/01/1990</td>
                    <td class='item-cerchiato'>ABC123456789</td>
                </tr>
            </tbody>
        </table>
        
</body>
</html>
