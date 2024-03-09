
function RichiamaFunzionePhp(dir_funzione, nome_funzione, parametro) {
    $.ajax({
        url: dir_funzione,
        type: 'POST',
        data: { 
            action: nome_funzione, 
            param: parametro
            }
        /*
        ,
        success: function(success) {
            alert("tabella aggiornata");
        },
        error: function(error) {
            console.log("errore di visualizzazione");
        }
        */
    });
}

/**
 * richiama la funzione "RichiamaFunzionePhp" - passaggio valore di @utenza
 * per cambiare live il response delle query
 */
function VisualizzaUtenza(){
    var utenza = document.getElementById("utenza");

    RichiamaFunzionePhp("Ricerca.php", "visualizza", utenza.value);
}
