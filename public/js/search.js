$(document).ready(function(){

    $('#search').click(function() {

            var str = "";

            $("select[id='critiere'] option:selected").each(function () {
                str += $(this).attr('value');

                console.log(str);
            });

            var search_input = $('#search_input').val();
            if (str == "nom") {
                $.get("http://127.0.0.1:8000/clients/name/" + search_input,
                    {},
                    function (data, status) {
                        $('tbody *').remove();
                        $('tbody').prepend(data);
                    });


            }
            else if (str == "type_de_client") {

                $("select[id='TypesClients'] option:selected").each(function () {

                    var type = $(this).attr('value');
                    console.log(type);
                    $.get("http://127.0.0.1:8000/clients/type/" + type,
                        {}, function (data, status) {

                            $('tbody *').remove();
                            $('tbody').prepend(data);
                        });


                })

            }
            else if(str == "city")
           {
             var city_input = $('#city_input').val();
               $.get("http://127.0.0.1:8000/clients/city/" + city_input,
                   {}, function (data, status) {

                       $('tbody *').remove();
                       $('tbody').prepend(data);
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

