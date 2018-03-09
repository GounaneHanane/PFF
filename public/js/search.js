$(document).ready(function(){

    $('#search').click(function() {

        var nameCustomer = $('#client_name').val();
        var ville = $ ('#ville').val();
        var  type_client = $('#type_client').val();
        critiere = {};

        if(nameCustomer != "" && nameCustomer != null)
            critiere['name'] = nameCustomer;

        if(ville != "" && ville != null)
            critiere['ville'] = ville;

        if(type_client != "" && type_client != null)
            critiere['type_client'] = type_client;

        if(critiere['name'] != null)
        {
            $.get("http://127.0.0.1:8000/clients/critiere/",
                critiere
                ,

                function (data, status) {

                                          $('tbody *').remove();
                                          $('tbody').prepend(data);

               console.log(status);
                    console.log(data);
                });
        }

            });

    $('#refresh').click(function(){
        $.get("http://127.0.0.1:8000/clients/all",
            {

            },
            function(data, status){
                $('tbody *').remove();
                $('tbody').prepend(data);
            });

    });


    $("select[id='critiere']").change(function() {
        $("select[id='critiere'] option:selected").each(function () {
            var choice = $(this).attr('value');
            if (choice == "nom") {
                $('#TypesClients').hide();
                $('#city_input').hide();
                $('#search_input').show();

            }
            else if (choice == "type_de_client") {
                $('#TypesClients').show();
                $('#city_input').hide();
                $('#search_input').hide();
            }
            else if (choice == "city") {
                $('#TypesClients').hide();
                $('#city_input').show();
                $('#search_input').hide();
            }


        });

    });


});

