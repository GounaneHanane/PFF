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

var checkVehicle=true;

$(document).ready(function(){

    $('#addContratBtn').click(function(){

        var ncontrat = $("#ncontrat").val();
        var dated=$("#dated").val();
        var client=$("#client").val();
        var  inputs = [ 'ncontrat','dated','client'];

        for(var j = 0;j<inputs.length;j++)
        {


            if ($('#Err' + inputs[j]).length) {


                $('#Err' + inputs[j]).remove();

            }


           alert('hola');


        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat/addcontrat',
            type: 'POST',
            data: {
                ncontrat: ncontrat,
                dated: dated,
                client : client,
                _token : $('#ContratToken').attr('value')
            },
            success: function (data, status) {
                console.log(data);
                alert(data);
                var contrat=document.getElementById('contrat');
                var vehicles=document.getElementById('vehicles');
                contrat.style.opacity=0.2;
                vehicles.style.opacity=1;
                window.location.href = '#vehicles';

                var  inputs = [ 'ncontrat','dated','client'];


                for(var j = 0;j<inputs.length;j++)
                {


                    if ($('#Err' + inputs[j]).length) {


                        $('#Err' + inputs[j]).remove();

                    }





                }


            },
            error: function (jqXhr) {console.log(jqXhr);

                if (jqXhr.status === 422) {
                    var errors = jqXhr.responseJSON;
                    $.each( errors.message , function( key, value ) {
                        console.log(errors);

                        var l = 0;
                        $.each(errors.message, function (key, value) {
                            // errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.

                            if ($('#Err' + key).length) {
                                //$('#Err' + key).html(value);

                                $('#Err' + key).text(value);
                            }
                            else {
                                $("#" + key).parent().append("<small id='Err" + key + "' class='text-danger'> " + value + "</small>");
                                l++;

                            }
                        });



                    });

                    // $( '#form-errors' ).html( errorsHtml );

                }
            }

        })




    });
    $('#recheche').click(function(){

        var critiere = {};

         var matricule = $('#mat').val();
         var client = $('#customer').val();
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


            });


        clear();
    });

    $('#refresh').click(function(){
          $.get("/contrat/refresh/",{},function(data,status){
              $('tbody *').remove();
              $('tbody').prepend(data);
          });
    });

    $('#addContratBtn').click(function(){
        var ncontrat = $("#ncontrat").val();
        var dated=$("#dated").val();
        var client=$("#client").val();
        var  inputs = [ 'ncontrat','dated','clients'];

        for(var j = 0;j<inputs.length;j++)
        {


            if ($('#Err' + inputs[j]).length) {


                $('#Err' + inputs[j]).remove();

            }





        }
        console.log(client + " " + dated + " " + ncontrat);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat/addcontrat',
            type: 'POST',
            data: {
                ncontrat: ncontrat,
                dated: dated,
                client : client,
                _token : $('#ContratToken').attr('value')
            },
            success: function (data, status) {

                var contrat=document.getElementById('contrat');
                var vehicles=document.getElementById('vehicles');
                contrat.style.opacity=0.2;
                vehicles.style.opacity=1;
                window.location.href = '#vehicles';

                var  inputs = [ 'ncontrat','dated','client'];

                for(var j = 0;j<inputs.length;j++)
                {


                    if ($('#Err' + inputs[j]).length) {


                        $('#Err' + inputs[j]).remove();

                    }





                }

                var vehicles = null;
                if(data['vehicles'] != null)
                    vehicles = data['vehicles'];


                if(vehicles.length > 0 && vehicles != null) {
                    for (var x = 0; x < vehicles.length; x++) {
                        $('#matricule').append($('<option value='+vehicles[x].id +'>' +vehicles[x].imei+ '</option>'));
                    }
                }

            },
            error: function (jqXhr) {console.log(jqXhr);

                if (jqXhr.status === 422) {
                    var errors = jqXhr.responseJSON;
                    $.each( errors.message , function( key, value ) {
                        $.each(errors.message, function (key, value) {
                            // errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.

                            if ($('#Err' + key).length) {
                                //$('#Err' + key).html(value);

                                $('#Err' + key).text(value);

                            }
                            else
                                $("#" + key).parent().append("<small id='Err" + key + "' class='text-danger'> " + value + "</small>");


                        });



                    });

                    // $( '#form-errors' ).html( errorsHtml );

                }
            }

        })




    });



    $('#AddDetail').click(function(){

        var matricule = $('#matricule').val();
        var typeAbonnement = $('#typeAbonnement').val();
        var price = $('#price').val();
        var newVehicle = 0;
        var client = $('#client').val();

        var marque = $('#marque').val();
        var model = $('#model').val();
        var imei = $('#imei').val();


        if(!checkVehicle) {
            newVehicle = 1;


        }
        else
            newVehicle = 0;

        console.log(newVehicle);



        console.log(matricule + " " + typeAbonnement + " " + price);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat/addDetail',
            type: 'POST',
            data: {
                client: client,

                typeAbonnement: typeAbonnement,
                matricule: matricule,
                price: price,

                newvehicle : newVehicle,
                model : model,
                imei:imei,
                marque:marque,
                _token: $('#DetailToken').attr('value')
            },

            success: function (data, status) {
                console.log(data);
            },
            error: function (jqXhr) {console.log(jqXhr);

                if (jqXhr.status === 422) {
                    var errors = jqXhr.responseJSON;
                    $.each( errors.message , function( key, value ) {
                        $.each(errors.message, function (key, value) {
                            // errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.

                            if ($('#Err' + key).length) {
                                //$('#Err' + key).html(value);

                                $('#Err' + key).text(value);

                            }
                            else {
                                $("#" + key).parent().append("<small id='Err" + key + "' class='text-danger'> " + value + "</small>");

                            }
                        });



                    });

                    // $( '#form-errors' ).html( errorsHtml );

                }
            }

        });


        $('#matricule').val(0);
        $('#typeAbonnement').val(0);
        $('#price').val('');

    });

    $("#typeAbonnement").change(function() {

        var client = $("#client").val();

        $("#typeAbonnement option:selected").each(function () {

            var choice = $(this).attr('value');
            $.get("/contrat/price/"+client+"/"+choice,


                {

                },

                function (data, status) {
                    console.log(data);
                   $('#price').val(data);

                });



        });

    });


});