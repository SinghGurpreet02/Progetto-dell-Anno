<!DOCTYPE html>
<head>  
<link rel="stylesheet" href="style.css">
        <?php //inclusioni di file esterni

            include("connessione.php");

        ?>

    <title>Interfaccia</title>
</head>
<body>

    <nav>
        <a href="#">Home</a>
        <a href="#">Ricerca</a>
    </nav>

                            <!--
                            <div class="container">
                                <div class="sidebar">
                                    <h2>Ricerca</h2>
                                    <form>
                                        <label for="searchName">Nome:</label>
                                        <input type="text" id="searchName" name="searchName">

                                        <label for="searchSurname">Cognome:</label>
                                        <input type="text" id="searchSurname" name="searchSurname">

                                        <label for="searchCF">Codice Fiscale:</label>
                                        <input type="text" id="searchCF" name="searchCF">

                                        <label for="searchDOB">Data di Nascita:</label>
                                        <input type="text" id="searchDOB" name="searchDOB">

                                        <button type="submit">Cerca</button>
                                    </form>
                                </div>

                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cognome</th>
                                            <th>Data di Nascita</th>
                                            <th>Codice Fiscale</th>
                                            <th>ZZemptyZZ</th>
                                            <th>Seleziona</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mario</td>
                                            <td>Rossi</td>
                                            <td>01/01/1990</td>
                                            <td>ABC123456789</td>
                                            <td>Contenuto</td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        </tbody>
                                </table>
                            </div>
                            -->


    <table>
        <div>
        <?php //stampa campi tabella inziali e dati rispettivi
            echo"<tr>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Data di Nascita</th>
                <th>Codice Fiscale</th>
                <th>ZZemptyZZ</th>
                <th>Seleziona</th>
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
                <td>Mario</td>
                <td>Rossi</td>
                <td>01/01/1990</td>
                <td>ABC123456789</td>
                <td>Contenuto</td>
                <td><input type="checkbox"></td>
            </tr>


        </tbody>
    </table>

</body>
</html>