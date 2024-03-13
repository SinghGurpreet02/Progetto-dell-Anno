error_reporting(E_ALL);
ini_set('display_errors', 1);

function RichiamaFunzionePhp(dir_funzione, nome_funzione, parametro) {
    jQuery.ajax({
        url: dir_funzione,
        type: 'POST',
        data: { 
        aggiorna: nome_funzione, 
        param: parametro
        },
        success: function(success) {
            alert("funzione richiamata");
        },
        error: function(error) {
            console.log("errore");
        }
    });
}

/**
 * richiama la funzione "RichiamaFunzionePhp" - passaggio valore di @utenza
 * per cambiare live il response delle query
 */
function VisualizzaUtenza(){
    var utenza = document.getElementById("utenza");
    
    RichiamaFunzionePhp("Ricerca.php", "aggiorna", utenza.value);
}
