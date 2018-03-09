$(document).ready(function(){
    var vehicles={"tab_num_contart":null,"tab_matricule":null,"tab_model":null,"tab_marque":null,"tab_type_abonnement":null,"tab_reference_boitier":null,"tab_type_boitier":null};
    var v = { vehicle : [] };
    var car;
    var obj;
    var i=0;
    $(".addcar").click(function () {



             addDetail();





        i++;

    });
    $(".trash").click(function(){
        alert("x");
        $('#vehicles_table').find('input[type="checkbox"]:checked').each(function () {
            $( this ).parent().parent().remove();
        });
    });







function addClient() {
    var nom = $("#nom").val();
    var city=$("#ville").val();
    var phone=$("#telephone").val();
    var mail=$("#email").val();
    var type_client=$("#type_client").val();
    var contact=$("#contact").val();
    var ncontact=$("#NContact").val();
    var address=$("#address").val();
    var  inputs = [ 'nom','contact','telephone','email','NContact','ville','address','type_client'];

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
            url: 'http://127.0.0.1:8000/add',
            type: 'POST',
            data: {
                nom: nom,
                contact: contact,
                telephone: phone,
                email: mail,
                NContact: ncontact,
                ville: city,
                address : address,
                type_client : type_client,
                _token : $('#ClientToken').attr('value')
            },
            success: function (data, status) {
                $('#contrat_save').val(data);
                $('#contrat :input').attr('disabled', false);
                document.getElementById("contrat").style.opacity = "1";
                window.location.href = '#contrat';
                document.getElementById("client").style.opacity = "0.2";
                $('#client :input').attr('disabled', true);

                var  inputs = [ 'nom','contact','telephone','email','NContact','ville','address','type_client'];

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




                    $.each( errors.message , function( key, value ) {
                       // errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                        $("#" + key).parent().append("<small id='Err" + key + "' class='text-danger'> " + value + "</small>");



                });

                   // $( '#form-errors' ).html( errorsHtml );

                }
            }

        })




//    }
}
var i=0;
    function addDetail() {
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

                //alert();

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

                $("tbody").prepend("<tr class=\"vehicle_line\"><td class=\"liste_matricule\">"+matricule+"</td><td class=\"liste_marque\">"+mark+"</td><td class=\"liste_model\">"+model+"</td></td><td class=\"liste_reference_boitier\">"+reference_boitier+"</td><td class=\"liste_type_boitier\">"+type_boitier+"</td><td class=\"liste_type_abonnement\">"+type_abonnement+"</td>" +
                  "<td class='text-center'><a id='deleteDetail' alt='"+matricule+ "' class='btn btn-danger' ><span class='glyphicon glyphicon-trash edit trash'></span></a>"+
                   "<a class='btn btn-info' id='edit' onclick='editDetail()' alt='"+i+"'><span class='glyphicon glyphicon-pencil edit edit_pencil' ></span></a></td>" +
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

                    var i = 0;
                    $.each(errors.message, function (key, value) {
                        // errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.

                        if ($('#Err' + key).length) {
                            //$('#Err' + key).html(value);

                            $('#Err' + key).text(value);
                        }
                        else {
                            $("#" + key).parent().append("<small id='Err" + key + "' class='text-danger'> " + value + "</small>");
                            i++;

                        }
                    });

                }}})


    }






  $('#add_client').click(function(){
       addClient();
  });






});


function editDetail()
{

    var lines=$("#edit").parent().parent();
    alert(lines.children('.liste_matricule').text());
    $("#matricule").val(lines.children('.liste_matricule').text());
    $("#type_vehicule").val(lines.children('.liste_type_vehicule').text());
    $("#mark").val(lines.children('.liste_marque').text());
    $("#modele").val(lines.children('.liste_model').text());
    $("#reference_boitier").val(lines.children('.liste_reference_boitier').text());
    $("#type_boitier").val(lines.children('.liste_type_boitier').text());
    $("#type_abonnement").val(lines.children('.liste_type_abonnement').text());
    var alt=$( "#edit" ).alt;
    alert(alt);
    delete vehicles.tab_matricule[alt];
    delete vehicles.tab_marque[alt];
    delete vehicles.tab_model[alt];
    delete vehicles.tab_type_boitier[alt];
    delete vehicles.tab_reference_boitier[alt];
    delete vehicles.tab_type_boitier[alt];
    delete vehicles.tab_type_abonnement[alt];
    lines.remove();
}


