 $(document).ready(function() {

    $("#alert").change(function () {

        var id = $("#alert").val();

        $.get("/alert/" + id, {}, function (data, status) {

            $("tbody *").remove();
            $("tbody ").append(data);

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
})

function renewal(id)
{

    $.get("/alerte/renv/" + id, {}, function (data, status) {

      var detail_contract=data["info"];
        var vehicles=data["vehicles"];
      $('#nbVehiclesAdvanced').val(detail_contract.nbAvance);
        $('#nbVehiclesSimple').val(detail_contract.nbSimple);
        $('#defaultAdvanced').val(detail_contract.defaultAvance);
        $('#defaultSimple').val(detail_contract.defaultSimple);
        $('#priceVehiclesSimple').val(detail_contract.defaultSimple*detail_contract.nbSimple);
        $('#priceVehiclesAdvanced').val(detail_contract.defaultAvance*detail_contract.nbAvance);


            for(var  i = 0; i < vehicles.length; i++)
            {
                $('#OldVehicles').append("<option>"+vehicles[i].imei+"</option>");
            }

         //   console.log(table);


    });

}


