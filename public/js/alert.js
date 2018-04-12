 $(document).ready(function() {

    $("#alert").change(function () {

        var id = $("#alert").val();

        $.get("/alert/" + id, {}, function (data, status) {

            $("tbody *").remove();
            $("tbody ").append(data);

        });

    });
})

function renewal(id)
{
    alert(id);
    /*
    $.get("/renewal/" + id, {}, function (data, status) {

        console.log(data);

    });
*/
}


