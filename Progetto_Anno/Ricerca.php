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
    <style>
        .ricerca{  
  			margin-top: 10px;
  		}
        .container_Ricerca{
            display: flex;
        }
        .divider {
            flex: 1;
            height: 1px;
            background-color: #ccc;
            margin: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        select {
            width: 50%;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <nav>
        <a href="#">Home</a>
        <a href="#">Ricerca</a>
    </nav>

    <div class="container">
        <div class="divider divider-1"></div>
        <div class="divider divider-2"></div>
        <table>
            <thead>
                <tr>
                    <th></th>
                    
                    <th>ID_Operatore</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>id_corpo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Mario</td>
                    <td>Rossi</td>
                    <td>01/01/1990</td>
                    <td>ABC123456789</td>
                </tr>
            </tbody>
        </table>
    </div >
    <div class="container_Ricerca">
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
    </div>


     



</body>
</html>