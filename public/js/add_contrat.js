$(document).ready(function(){





   /* $('#contratTable').paginate({

        limit: 2,
        initialPage: 2
    });*/
    $('#addVehicleBtn2').click(function(){

        var imei = $("#vehicules").val();
        var typeSubscribe=$("#types").val();
        var price=$("#priceVehicles").val();
        var date=$('#AddingDate').val();
        var  inputs = [ 'vehicles','types','priceVehicles','addingDate'];
        for(var j = 0;j<inputs.length;j++)
        {


            if ($('#Err' + inputs[j]).length) {


                $('#Err' + inputs[j]).remove();

            }





        }


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'http://127.0.0.1:8000/contract/addVehicule/',
            type: 'POST',
            data: {
                vehicules: imei,
                types: typeSubscribe,
                priceVehicles: price,
                AddingDate:date,
                _token : $('#VehicleToken').attr('value')
            },
            success: function (data, status) {

                var  inputs = [ 'vehicles','types','priceVehicles','addingDate' ];
console.log(data.dated);
                for(var j = 0;j<inputs.length;j++)
                {


                    if ($('#Err' + inputs[j]).length) {


                        $('#Err' + inputs[j]).remove();

                    }





                }


            },
            error: function (jqXhr) {
                if (jqXhr.status === 422) {
                    var errors = jqXhr.responseJSON;

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


                    // $( '#form-errors' ).html( errorsHtml );

                }
            }

        })




    });



});









function ShowType(typeClientId,typeAbonnmenetId,price) {

    document.getElementById('add_dialog').showModal();
    var tabAbonnement=document.getElementById("type_abonnement");
    var tabClient=document.getElementById("client");
    var tabClienttLength=tabClient.length;
    checkVehicle=true;
    var tabAbonnementLength=tabAbonnement.length;
    document.getElementById("edit_title").style.display="inline";
    document.getElementById("add_title").style.display="none";
    document.getElementById("addOrEditButton").firstChild.data="Modifier";
    for(var i=0;i<tabAbonnementLength;i++)
    {
        if(tabAbonnement[i].value==typeAbonnmenetId)
            tabAbonnement[i].selected=true;
    }
    for(var i=0;i<tabClienttLength;i++)
    {
        if(tabClient[i].value==typeClientId)
            tabClient[i].selected=true;
    }
    document.getElementById("price").value=price;
}

function addContrat(){
    var contrat=document.getElementById('contrat');
    var vehicles=document.getElementById('vehicles');
    contrat.style.opacity=0.2;
    vehicles.style.opacity=1;
    window.location.href = '#vehicles';
    contrat.action="/contrat/addcontrat";
}
function addContratDialog()
{

    var contrat=document.getElementById('contrat');
    var vehicles=document.getElementById('vehicles');
    contrat.style.opacity=1;

    $("#client").val('0');
    $('#date').val('');
    $('#matricule * ').remove();


    var tabClient=document.getElementById("client");
    var tabClienttLength=tabClient.length;
   /* var tabAbonnement=document.getElementById("typeAbonnement");
    var tabAbonnementLength=tabAbonnement.length;
    var tabInt=document.getElementById("marque");
    var tabIntLength=tabInt.length;
    document.getElementById("price").value="";
    document.getElementById("dated").value="";
    checkVehicle=true;*/
    document.getElementById('add_dialog').showModal();
   /* for(var i=0;i<tabClienttLength;i++)
    {

        if(tabClient[i].id=="defaultCli")
            tabClient[i].selected=true;
    }

    for(var i=0;i<tabAbonnementLength;i++)
    {
        if(tabAbonnement[i].id=="defaultAbo")
            tabAbonnement[i].selected=true;
    }*/

}
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
function disableDetail(idDet,idCon)
{

    $.get("/detail/delete/"+idDet,{},function(data, status){


        $("#Detail"+idDet).remove();
       /* $.get("/contrat/detail/refresh/"+idCon, {}, function (data, status) {
            console.log(data);
            $('tbody *').remove();
            $('tbody').prepend(data);
        });*/
    });
}



$(document).ready(function() {



    $('#recheche').click(function(){


        var critiere = {};

        var matricule = $('#mat').val();
        var client = $('#customer').val();
        var debut_contrat = $('#debut_contrat').val();
        var fin_contrat = $('#fin_contrat').val();
        var typeClient = $('#typeClient').val();

        critiere = {};

        if (matricule != "" && matricule != null)
            critiere['id_contract'] = matricule;

        if (client != "" && client != '0')
            critiere['id_customer'] = client;

        if (debut_contrat != "" && debut_contrat != null)
            critiere['debut_contrat'] = debut_contrat;

        if (fin_contrat != "" && fin_contrat != null)
            critiere['fin_contrat'] = fin_contrat;

        if (typeClient != "" && typeClient != '0')
            critiere['typeClient'] = typeClient;


        $.get("/contrat/search/",
            critiere
            ,

            function (data, status) {

                $('tbody *').remove();
                $('tbody').prepend(data);


            });


        clear();
    });

    $("#addContractModal").click(function()
    {
        var today = new Date();
        $("#client").val("0");
        $("#dated").val(today.getFullYear()+"-"+today.getMonth()+"-"+today.getDay());
        $("#defaultAdvanced").val("");
        $("#defaultSimple").val("");
        $("#nbVehiclesAdvanced").val("");
        $("#nbVehiclesSimple").val("");
        $("#priceVehiclesAdvanced").val("");
        $("#priceVehiclesSimple").val("");
        $("#NbVehicles").text("");

        document.getElementById('add_dialog').showModal();

    });





    $('#refresh,#AddDetail,#AddDetailGamme,#btnCancel,#CancelContract,#ModifyContract').click(function(){
        $.get("/contrat/refresh/",{},function(data,status){
            $('tbody *').remove();
            $('tbody').prepend(data);
        });
    });



    $("#AddDetailGamme").click(function(){
        var typeAbonnement = $('#typeAbonnement').val();
        var nbVehiclesSimple = $('#nbVehiclesSimple').val();
        var nbVehiclesAvance = $('#nbVehiclesAdvanced').val();
        var date = $('#dated').val();
        var priceVehiclesSimple =  $('#priceVehiclesSimple').val();
        var priceVehiclesAvance =  $('#priceVehiclesAdvanced').val();
        var defaultSimple = $("#defaultSimple").val();
        var defaultAvance = $("#defaultAdvanced").val();

        var client = $('#client').val();





        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat/addcontrat',
            type: 'POST',
            data: {
                client: client,
                nbVehiclesSimple: nbVehiclesSimple,
                nbVehiclesAvance : nbVehiclesAvance,
                defaultSimple : defaultSimple,
                defaultAvance : defaultAvance,
                priceVehiclesSimple : priceVehiclesSimple,
                priceVehiclesAvance : priceVehiclesAvance,
                dated :date,
                _token: $('#ContratToken').attr('value')
            },

            success: function (data, status) {
                console.log(data);
                document.getElementById('add_dialog').close();

                $.get("/contrat/refresh/", {}, function (data, status) {
                    $('tbody *').remove();
                    $('tbody').prepend(data);
                });
            }
        });



    });

    $("#ModfiyContract").click(function(){
        var nbvehiclesSimple = $("#ModifynbVehiclesSimple").val();
        var nbvehiclesAvance = $("#ModifynbVehiclesAdvanced").val();

        var priceAvance = $("#ModifyPriceAdvanced").val();
        var priceSimple = $("#ModifyPriceSimple").val();

        var defaultAvance = $("#ModifyDefaultAdvanced").val();
        var defaultSimple = $("#ModifyDefaultSimple").val();


        var client = $("#clientMaj").val();



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contract/Modify',
            data : {
               client : client,
               nbAvance : nbvehiclesAvance,
               nbSimple : nbvehiclesSimple,
               priceAvance : priceAvance,
               priceSimple : priceSimple,
               defaultAvance : defaultAvance,
               defaultSimple : defaultSimple,
               _token : $("#ContratToken").attr('value')
            },
            type: 'POST',

            success: function (data, status) {
            }

        });

    });









    $("#client").change(function () {

        var client = $("#client").val();
        $.get("/contrat/price/" + client, {}, function (data, status) {
            $("#defaultAdvanced").val(data.priceAvance);
            $("#defaultSimple").val(data.priceSimple);
            $("#NbVehicles").text(data.nbVehicles);
            $("#NbVehicles").attr('alt',data.nbVehicles);

        });
    });












    $('#nbVehiclesAdvanced,#defaultAdvanced').change(function () {
           var defaultAvance = $("#defaultAdvanced").val();
           var nbVAd = $("#nbVehiclesAdvanced").val();
           var baseVehicles =  $("#NbVehicles").text();




               var result = defaultAvance * nbVAd;



           $("#priceVehiclesAdvanced").val(result);

    });
    $('#nbVehiclesSimple,#defaultSimple').change(function () {
        var defaultSimple = $("#defaultSimple").val();
        var nbVS = $("#nbVehiclesSimple").val();




        var result = defaultSimple * nbVS;

       $("#priceVehiclesSimple").val(result);
        console.log(defaultSimple + " "+ nbVS + " " + result);

    });

    $('#ModifynbVehiclesAdvanced,#ModifyDefaultAdvanced').change(function () {
        var defaultAvance = $("#ModifyDefaultAdvanced").val();
        var nbVAd = $("#ModifynbVehiclesAdvanced").val();


        var result = defaultAvance * nbVAd;

        $("#ModifyPriceAdvanced").val(result);

    });
    $('#ModifynbVehiclesSimple,#ModifydefaultSimple').change(function () {

        var defaultSimple = $("#ModifyDefaultSimple").val();
        var nbVS = $("#ModifynbVehiclesSimple").val();

        var result = defaultSimple * nbVS;


        $("#ModifyPriceSimple").val(result);
        //  console.log(defaultSimple + " "+ nbVS + " " + result);

    });






    });
function editContratDialog(id) {
    document.getElementById('edit_dialog').showModal();


    $.get("/contrat/update/" + id, {}, function (data, status) {


        var contracts = data["contracts"];
        var date = contracts.start_contract;
        var customer = data["customer"];
        $('#edit_dialog #dated').val(date);
        $('#ModifynbVehiclesAdvanced').val(contracts.nbAvance);
        $('#ModifyPriceAdvanced').val(contracts.priceAvance);
        $('#ModifynbVehiclesSimple').val(contracts.nbSimple);
        $("#ModifyPriceSimple").val(contracts.priceSimple);
        $("#ModifyDefaultAdvanced").val(contracts.defaultAvance);
        $("#ModifyDefaultSimple").val(contracts.defaultSimple);
         $("#ModifyNbVehicles").text(contracts.nbVehicles);


        console.log(contracts.nbVehicles);




       $('#clientMaj').append($('<option id="added"  value="' + customer.id + '">' + customer.name + '</option>'));



    })

}

