function clear()
{
    $('#matricule').val('');
    $('#client').val(0);
    $('#debut_contrat').val('');
    $('#fin_contrat').val('');
    $('#typeClient').val(0);
}

function disableContract(id)
{





    $.get("/contrat/delete/"+id,{},function(data, status){


        $("#Contrat"+id).remove();
    });

}

$(document).ready(function(){

    $('#recheche').click(function(){

        var critiere = {};

         var matricule = $('#matricule').val();
         var client = $('#client').val();
         var debut_contrat = $('#debut_contrat').val();
         var fin_contrat = $('#fin_contrat').val();
         var typeClient = $('#typeClient').val();

        critiere = {};

        if(matricule != "" && matricule != null)
            critiere['id_contract'] = matricule;

        if(client != "" && client != '0')
            critiere['id_customer'] = client;

        if(debut_contrat != "" && debut_contrat != null)
            critiere['debut_contrat'] = debut_contrat;

        if(fin_contrat != "" && fin_contrat != null)
            critiere['fin_contrat'] = fin_contrat;

        if(typeClient != "" && typeClient != '0')
                    critiere['typeClient'] = typeClient;


        $.get("http://127.0.0.1:8000/contrat/search/",
            critiere
            ,

            function (data, status) {

                $('tbody *').remove();
                $('tbody').prepend(data);

                console.log(status);
                console.log(data);
            });


         console.log(matricule + " " + client + " " + debut_contrat + " " + fin_contrat + " " + typeClient);
        clear();
    });

    $('#refresh').click(function(){
          $.get("/contrat/refresh/",{},function(data,status){
              $('tbody *').remove();
              $('tbody').prepend(data);
          });
    });




});