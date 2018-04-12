 $(document).ready(function() {

    $("#alert").change(function () {

        var id = $("#alert").val();

        $.get("/alert/" + id, {}, function (data, status) {

            $("tbody *").remove();
            $("tbody ").append(data);

        });

    });
})


