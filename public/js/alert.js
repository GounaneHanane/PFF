 $(document).ready(function() {

    $("#alert").change(function () {

        var id = $("#alert").val();
//console.log(id);
        $.get("/alert/" + id, {}, function (data, status) {
            //console.log(id);
            console.log(data);
            $("tbody *").remove();
            $("tbody ").append(data);

        });

    });



    $("#BtnAlertCancel").click(function()
    {
            document.getElementById('add_dialog').close();
             $.get("/alert/refresh/", {}, function (data, status) {

            $('tbody *').remove();
            $('tbody').prepend(data);

        });

    });



    $('#AllIn').click(function () {
        var vehicles=$('#OldVehicles option');
        for(var i=0;i<vehicles.length;i++)
        {
            $('#NewVehicles').append(vehicles[i]);
        }

    });
     $('#AllOut').click(function () {
         var vehicles=$('#NewVehicles option');
         for(var i=0;i<vehicles.length;i++)
         {
             $('#OldVehicles').append(vehicles[i]);
         }
     });
     $('#OneOut').click(function () {
         $( "#NewVehicles option:selected" ).each(function() {

             $('#OldVehicles').append("<option>"+$( this ).text()+"</option>");


             $(this).remove();
         });
     });
     $('#OneIn').click(function () {
         $( "#OldVehicles option:selected" ).each(function() {

             $('#NewVehicles').append("<option>"+$( this ).text()+"</option>");
             $(this).remove();
         });
     });
     $('#AddRenGamme').click(function () {
        var id_detail=$('#id_detail').val();
         var nbVehiclesSimple = $('#nbVehiclesSimple').val();
         var nbVehiclesAdvanced = $('#nbVehiclesAdvanced').val();
         var date = $('#dated').val();
         var priceVehiclesSimple =  $('#priceVehiclesSimple').val();
         var priceVehiclesAdvanced =  $('#priceVehiclesAdvanced').val();
         var defaultSimple = $("#defaultSimple").val();
         var defaultAdvanced = $("#defaultAdvanced").val();


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
                 nbVehiclesSimple: nbVehiclesSimple,
                 nbVehiclesAdvanced : nbVehiclesAdvanced,
                 defaultSimple : defaultSimple,
                 defaultAdvanced : defaultAdvanced,
                 priceVehiclesSimple : priceVehiclesSimple,
                 priceVehiclesAdvanced : priceVehiclesAdvanced,
                 dated :date,
                 _token: $('#GammeToken').attr('value')
             },

             success: function (data, status) {

                 document.getElementById('add_dialog').close();
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
function renewal(id)
{
    document.getElementById('add_dialog').showModal();
    $.get("/alerte/renv/" + id, {}, function (data, status) {

      var detail_contract=data["info"];
        var vehicles=data["vehicles"];
        $('#id_detail').val(id);
        $('#dated').val(detail_contract.end_contract);
      $('#nbVehiclesAdvanced').val(detail_contract.nbAvance);
        $('#nbVehiclesSimple').val(detail_contract.nbSimple);
        $('#defaultAdvanced').val(data["advancedPrice"].price);
        $('#defaultSimple').val(data["simplePrice"].price);
        $('#priceVehiclesSimple').val(detail_contract.defaultSimple*detail_contract.nbSimple);
        $('#priceVehiclesAdvanced').val(detail_contract.defaultAvance*detail_contract.nbAvance);


            for(var  i = 0; i < vehicles.length; i++)
            {
                $('#NewVehicles').append("<option>"+vehicles[i].imei+"</option>");
            }

         //   console.log(table);


    });

}


