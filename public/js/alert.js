 $(document).ready(function() {

     ////
     //// Menu
     ////
     $('.submenu-toggle').click(function () {
         $(this).parent().children('ul.submenu').toggle(200);
     });

     ////
    //// periode de l'alerte
    ////

    $("#alert").change(function () {

        var id = $("#alert").val();

        $.get("/alert/" + id, {}, function (data, status) {

            $("tbody *").remove();
            $("tbody ").append(data);

        });

    });


     ////
     //// Fermer le model
     ////

    $("#BtnAlertCancel").click(function()
    {
            document.getElementById('add_dialog_ren').close();
             $.get("/alert/refresh/", {}, function (data, status) {

            $('tbody *').remove();
            $('tbody').prepend(data);

        });

    });

     ////
     //// >>
     ////

    $('#AllIn').click(function () {
        var vehicles=$('#OldVehicles option');
        for(var i=0;i<vehicles.length;i++)
        {
            $('#NewVehicles').append(vehicles[i]);
        }

    });

     ////
     //// <<
     ////

     $('#AllOut').click(function () {
         var vehicles=$('#NewVehicles option');
         for(var i=0;i<vehicles.length;i++)
         {
             $('#OldVehicles').append(vehicles[i]);
         }
     });

     ////
     //// <
     ////

     $('#OneOut').click(function () {
         $( "#NewVehicles option:selected" ).each(function() {

             $('#OldVehicles').append("<option>"+$( this ).text()+"</option>");


             $(this).remove();
         });
     });

     ////
     //// >
     ////

     $('#OneIn').click(function () {
         $( "#OldVehicles option:selected" ).each(function() {

             $('#NewVehicles').append("<option>"+$( this ).text()+"</option>");
             $(this).remove();
         });
     });
     ////
     ////Prix de type avancé (model d'ajouter)
     ////
     $('#nbVehiclesAdvancedR,#defaultAdvancedR').change(function () {
         var defaultAvance = $("#defaultAdvancedR").val();
         var nbVAd = $("#nbVehiclesAdvancedR").val();
         var baseVehicles =  $("#NbVehicles").text();




         var result = defaultAvance * nbVAd;



         $("#priceVehiclesAdvancedR").val(result);

     });

     ////
     ////Prix de type simple (model d'ajouter)
     ////

     $('#nbVehiclesSimpleR,#defaultSimpleR').change(function () {
         var defaultSimple = $("#defaultSimpleR").val();
         var nbVS = $("#nbVehiclesSimpleR").val();




         var result = defaultSimple * nbVS;

         $("#priceVehiclesSimpleR").val(result);

     });

     ////
     //// Ajouter un renouvelement
     ////

     $('#AddRenGamme,#AddRenGammeC').click(function () {
        var id_detail=$('#id_detail').val();
         var nbVehiclesSimple = $('#nbVehiclesSimpleR').val();
         var nbVehiclesAdvanced = $('#nbVehiclesAdvancedR').val();
         var date = $('#datedR').val();
         var priceVehiclesSimple =  $('#priceVehiclesSimpleR').val();
         var priceVehiclesAdvanced =  $('#priceVehiclesAdvancedR').val();
         var defaultSimple = $("#defaultSimpleR").val();
         var defaultAdvanced = $("#defaultAdvancedR").val();


      /*   $('#NewVehicles option').each(function () {

            $('#NewVehicles option').attr('selected','true');

        });*/




       $.ajax({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url: '/renewal/',
             type: 'POST',
             data: {
                 id_detail: id_detail,
                 nbVehiclesSimpleR: nbVehiclesSimple,
                 nbVehiclesAdvancedR : nbVehiclesAdvanced,
                 defaultSimpleR : defaultSimple,
                 defaultAdvancedR : defaultAdvanced,
                 priceVehiclesSimpleR : priceVehiclesSimple,
                 priceVehiclesAdvancedR : priceVehiclesAdvanced,
                 datedR :date,
                 _token: $('#GammeToken').attr('value')
             },

             success: function (data, status) {

                 document.getElementById('add_dialog_ren').close();
                 var NewVehicles=[];
         $('#NewVehicles option').each(function(){
             NewVehicles.push($(this).val());

         });

         var id_detail=$('#id_detail').val();




                     $.ajax({
                             headers: {
                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             },
                             url: '/renewal/vehicles/',
                             type: 'POST',
                             data: {
                                 NewVehicles: NewVehicles,
                                 id_detail:id_detail,
                                 _token: $('#GammeToken').attr('value')}

                        ,
                        success: function (data, status) {
                                                $.get("/alert/refresh/", {}, function (data, status) {

                            $('tbody *').remove();
                            $('tbody').prepend(data);

                        });


                 }});
              //   }



     }});
});
 });

 ////
 //// Afficher le model de renouvler
 ////

function renewal(id)
{
    document.getElementById('add_dialog_ren').showModal();
    $.get("/alerte/renv/" + id, {}, function (data, status) {

      var detail_contract=data["info"];
        var vehicles=data["vehicles"];
        $('#id_detail').val(id);
        $('#datedR').val(detail_contract.end_contract);
      $('#nbVehiclesAdvancedR').val(detail_contract.nbAvance);
        $('#nbVehiclesSimpleR').val(detail_contract.nbSimple);
        $('#defaultAdvancedR').val(data["advancedPrice"].price);
        $('#defaultSimpleR').val(data["simplePrice"].price);
        $('#priceVehiclesSimpleR').val(detail_contract.defaultSimple*detail_contract.nbSimple);
        $('#priceVehiclesAdvancedR').val(detail_contract.defaultAvance*detail_contract.nbAvance);

        $('#NewVehicles option').remove();
            for(var  i = 0; i < vehicles.length; i++)
            {
                $('#NewVehicles').append("<option>"+vehicles[i].imei+"</option>");
            }



    });

}


