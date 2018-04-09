$(document).ready(function(){
    var vehicles={"tab_num_contart":null,"tab_matricule":null,"tab_model":null,"tab_marque":null,"tab_type_abonnement":null,"tab_reference_boitier":null,"tab_type_boitier":null};
    var v = { vehicle : [] };
    var car;
    var obj;
    var i=0;
    $(".addcar").click(function () {
        var matricule = $('#matricule').val();
        var mark = $('#mark').val();
        var model = $('#modele').val();
        var reference_boitier = $('#reference_boitier').val();
        var type_boitier = $('#type_boitier').val();
        var type_abonnement = $('#type_abonnement').val();


        var  inputs = [ 'matricule','modele','mark','reference_boitier','type_abonnement','type_boitier'];

        for(var j = 0;j<inputs.length;j++)
        {


            if ($('#Err' + inputs[j]).length) {

                //t();

                $('#Err' + inputs[j]).remove();

            }





        }



        //obj=JSON.parse(vehicles);
        vehicles.tab_matricule = matricule;
        vehicles.tab_marque = mark;
        vehicles.tab_model = model;
        vehicles.tab_type_abonnement = type_abonnement;
        vehicles.tab_reference_boitier = reference_boitier;
        vehicles.tab_type_boitier = type_boitier;
        v.vehicle.push(vehicles);
        console.log(vehicles);


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'http://127.0.0.1:8000/contract/addVehicule/',
            data: {
                matricule: matricule,
                mark: mark,
                modele:model,
                reference_boitier: reference_boitier,
                type_boitier: type_boitier,
                type_abonnement: type_abonnement,
                idContract : $('#contrat_save').val(),
                _token: $('meta[name="csrf-token"]').attr('content')

            },
            success: function (data) {
                console.log(data);
                $("#matricule").val('');
                $("#mark").val('');
                $("#reference_boitier").val('');
                $('#modele').val('');
                $('#type_boitier').val(1);
                $('#type_abonnement').val(1);

                $("#detail").prepend("<tr class=\"vehicle_line\"><td class=\"liste_matricule\">"+matricule+"</td><td class=\"liste_marque\">"+mark+"</td><td class=\"liste_model\">"+model+"</td></td><td class=\"liste_reference_boitier\">"+reference_boitier+"</td><td class=\"liste_type_boitier\">"+type_boitier+"</td><td class=\"liste_type_abonnement\">"+type_abonnement+"</td>" +
                    "<td class='text-center'><a id='deleteDetail' alt='"+matricule+ "' class='btn btn-danger' ><span class='glyphicon glyphicon-trash edit trash'></span></a>"+
                    "<a class='btn btn-info' id='"+i+"' onclick='editDetail("+i+")'><span class='glyphicon glyphicon-pencil edit edit_pencil' ></span></a></td>" +
                    "</tr>");

                i++;
                var  inputs = [ 'matricule','modele','mark','reference_boitier','type_abonnement','type_boitier'];

                for(var j = 0;j<inputs.length;j++)
                {


                    if ($('#Err' + inputs[j]).length) {

                        //alert();

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

                }}})

    });
    $(".trash").click(function(){

        $('#vehicles_table').find('input[type="checkbox"]:checked').each(function () {
            $( this ).parent().parent().remove();
        });
    });









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

                alert("Vehicule ajouté avec succés");
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



    $("vehicles").find('input').prop('disabled', true);
});

function editDetail(id)
{
    var lines=$("#"+id).parent().parent();

    $("#matricule").val(lines.children('.liste_matricule').text());
    $("#type_vehicule").val(lines.children('.liste_type_vehicule').text());
    $("#mark").val(lines.children('.liste_marque').text());
    $("#modele").val(lines.children('.liste_model').text());
    $("#reference_boitier").val(lines.children('.liste_reference_boitier').text());
    $("#type_boitier").val(lines.children('.liste_type_boitier').text());
    $("#type_abonnement").val(lines.children('.liste_type_abonnement').text());

}
var checkVehicle=true;
var checkVehicleEdit=true;
function addVehicle1() {
    if(checkVehicleEdit==true)
    {
        checkVehicleEdit=false;

        document.getElementById('newVehicle1').style.display='block';
        document.getElementById('selectVehicle1').style.display='none';
        console.log("hole");
    }
    else
    {
        checkVehicleEdit=true;
        document.getElementById('newVehicle1').style.display='none';
        document.getElementById('selectVehicle1').style.display='inline';
    }
}
function addVehicle() {
    if(checkVehicle==true)
    {

        checkVehicle=false;
        document.getElementById('newVehicle').style.display='inline';
        document.getElementById('selectVehicle').style.display='none';
    }
    else
    {
        checkVehicle=true;
        document.getElementById('newVehicle').style.display='none';
        document.getElementById('selectVehicle').style.display='inline';
    }
}


function saveContrat() {

    $('#saveContrat :input').attr('disabled', false);
    document.getElementById("saveContrat").style.opacity = "1";
    window.location.href = '#saveContrat';
    document.getElementById("contrat").style.opacity = "0.2";
    $('#contrat :input').attr('disabled', true);
    $("#savenom").text($("#nom").val());
    $("#contrat_show").text($("#contrat_save").val());
    $("#savecontact").text($("#contact").val());
    $("#savenumero").text($("#NContact").val());
}


/*
    $.get("/contrat/detailVehicles/"+id,{},function(data, status){

      var vehicles = data.vehicles;


      console.log(vehicles);
        for (var i = 0; i < vehicles.length; i++) {
            $('#edit_dialog #matricule').append($('<option id="added" value="' + vehicles[i].id + '">'  + vehicles[i].imei + '</option>'));
        }
    });
*/

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

    alert('hola');

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
    alert('hola');
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

    $('#refresh').click(function () {
        $.get("/contrat/refresh/", {}, function (data, status) {
            $('tbody *').remove();
            $('tbody').prepend(data);
        });
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
                alert("Contrat ajouté avec succés");
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


    $("#editVehicleBtn").click(function(){
        var date = $("#AddingDateEdit").val();
        var imei = $("#imeiId").val();
        var price=$('#priceVehiclesEdit').val();
        var type = $("#typesEdit").val();




        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contract/detail/Modify',
            data : {
                AddingDateEdit : date,
                imeiId : imei,
                typesEdit : type,
                priceVehiclesEdit : price,
                _token : $("#EditVehicleToken").attr('value')
            },
            type: 'POST',

            success: function (data, status) {
                alert('Vehicule modifié avec succée');
            }

        });

    });

    $("#ContratInfosearch").click(function(){
           var model = $("#model").val();
           var marque = $("#marque").val();
           var type_abonnement = $("#type_abonnement").val();
           var imei = $("#imei").val();
           var date = $("#dateAjout").val();
           var idContract = $(".body").attr('alt');

        critiere = {};

        critiere['idContract'] = idContract;

        if (imei != "" &&  imei != null)
            critiere['imei'] = imei;

        if (type_abonnement != "" && type_abonnement != '0')
            critiere['type_abonnement'] = type_abonnement;

        if (marque != "" && marque != null)
            critiere['marque'] = marque;

        if (model != "" && model != null)
            critiere['model'] = model;

        if (dateAjout != "" && dateAjout != null)
            critiere['dateAjout'] = date;

        console.log(critiere);

        $.get("/detail/search/",critiere,function(data, status){

            console.log(data);
            $('tbody *').remove();
            $('tbody').prepend(data);
        });


         $("#model").val('');
           $("#marque").val('');
           $("#type_abonnement").val("0");
           $("#imei").val('');
           $("#dateAjout").val();


});


    //var id = $("#client").val();
    /*



     */

    $("#client").change(function () {

        var client = $("#client").val();
        $.get("/contrat/price/" + client, {}, function (data, status) {
            $("#defaultAdvanced").val(data.priceAvance);
            $("#defaultSimple").val(data.priceSimple);
            $("#NbVehicles").text(data.nbVehicles);
            $("#NbVehicles").attr('alt',data.nbVehicles);

        });
    });


    $("#showModal").click(function(){


        document.getElementById('add_dialog').showModal();




    });



function editVehicleModel(idDetail) {
    document.getElementById('edit_dialog').showModal();
    $('#edit_dialog #imeiId').val($(' #' + idDetail + 'imei').text());
    $('#edit_dialog #AddingDateEdit').val($(' #' + idDetail + 'date').text());
    $('#edit_dialog #typesEdit option').each(function () {
        if ($(this).text() == $(' #' + idDetail + 'type').text())
            $(this).attr('selected', 'true');
    })
    $('#edit_dialog #priceVehiclesEdit').val($(' #' + idDetail + 'price').text());


}

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

        alert(defaultAvance + " " + nbVAd);

        var result = defaultAvance * nbVAd;

        $("#ModifyPriceAdvanced").val(result);

    });
    $('#ModifynbVehiclesSimple,#ModifydefaultSimple').change(function () {

        var defaultSimple = $("#ModifyDefaultSimple").val();
        var nbVS = $("#ModifynbVehiclesSimple").val();

        var result = defaultSimple * nbVS;

        //alert(defaultSimple+ " " + nbVS + " " + result);

        $("#ModifyPriceSimple").val(result);
        //  console.log(defaultSimple + " "+ nbVS + " " + result);

    });

    $("#refreshDetail").click(function(){

        var id = $('.body').attr('alt');

        $.get("/contrat/detail/refresh/"+id, {}, function (data, status) {
            $('tbody *').remove();
            $('tbody').prepend(data);

        });

    });

    $("#ValidatePrice").click(function () {

        var date = $("#AddingDate").val();
        var imei = $("#vehicules").val();
        var types = $("#types").val();





        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat//detail/price/calcul',

            type: 'POST',
            data: {
                AddingDate : date,
                types: types,
                vehicules :imei,
                _token: $('#VehicleToken').attr('value')
            },

            success: function (data, status) {
                console.log(data);
                $("#priceVehicles").val(data);
            }

        });


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



    })}