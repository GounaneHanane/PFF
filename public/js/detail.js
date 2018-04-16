$(document).ready(function(){

    $("#ValidatePrice").click(function () {

        var date = $("#AddingDate").val();
        var imei = $("#vehicules").val();
        var types = $("#types").val();





        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat/detail/price/calcul',

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

    $("#ValidatePriceEdit").click(function () {

        var date = $("#AddingDateEdit").val();
        var imei = $("#imeiId").val();
        var types = $("#typesEdit").val();
        var idContrat = $(".body").attr('alt');






        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat//detail/price/calculEdit',

            type: 'POST',
            data: {
                AddingDateEdit : date,
                typesEdit: types,
                imeiId :imei,
                _token: $('#EditVehicleToken').attr('value')
            },

            success: function (data, status) {
                console.log(data);
                $("#priceVehiclesEdit").val(data);
            }

        });


    });

    $("#edit_detail").click(function(){


        });


    $("#AddDetailModal").click(function(){


        document.getElementById('add_dialog').showModal();
        $("#vehicules").val("0");
        $("#AddingDate").val();
        $("#types").val("0");
        $("#priceVehicles").val("");



    });

    $("#refreshDetail,#editVehicleBtn,#CancelEditModel,#addVehicleBtn2").click(function(){

        var id = $('.body').attr('alt');

        $.get("/contrat/detail/refresh/"+id, {}, function (data, status) {

            $('#tableBody *').remove();
            $('#tableBody').prepend(data);

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
            $('#tableBody *').remove();
            $('#tableBody').prepend(data);
        });


        $("#model").val('');
        $("#marque").val('');
        $("#type_abonnement").val("0");
        $("#imei").val('');
        $("#dateAjout").val();


    });

});


    function editDetail(id) {



        document.getElementById('edit_dialog').showModal();

        $.get("/details/info/" + id, {}, function (data, status) {

            var detail = data["detail"];


            $("#imeiId").val(detail.imei);
            $("#AddingDateEdit").val(detail.AddingDate);
            $("#typesEdit").val(detail.id_subscribe);
            $("#priceVehiclesEdit").val(detail.price);
        })

    }



