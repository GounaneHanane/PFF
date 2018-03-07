$(document).ready(function(){
    var vehicles={"tab_num_contart":null,"tab_matricule":null,"tab_couleur":null,"tab_type_vehicule":null,"tab_marque":null,"tab_type_abonnement":null,"tab_reference_boitier":null,"tab_type_boitier":null};
    var v = { vehicle : [] };
    var car;
    var obj;
    var i=0;
    $(".addcar").click(function () {
        var contract = $("#contrat_save").val();
        var matricule=$("#matricule").val();
        var couleur=$("#couleur").val();
        var type_vehicule=$("#type_vehicule").val();
        var marque=$("#marque").val();
        var reference_boitier=$("#reference_boitier").val();
        var type_boitier=$("#type_boitier").val();
        var type_abonnement=$("#type_abonnement").val();



         if(matricule=="" || couleur=="" || type_vehicule=="" || marque=="" || reference_boitier=="" || type_abonnement=="" || type_boitier=="" )
         {
        	alert("Veuillez entrer tous les champs!");}
        else
         {
        //obj=JSON.parse(vehicles);
        vehicles.tab_num_contart = contract;
        vehicles.tab_matricule = matricule;
        vehicles.tab_couleur = couleur;
        vehicles.tab_type_vehicule = type_vehicule;
        vehicles.tab_marque = marque;
        vehicles.tab_type_abonnement = type_abonnement;
        vehicles.tab_reference_boitier = reference_boitier;
        vehicles.tab_type_boitier = type_boitier;
        v.vehicle.push(vehicles);
        console.log(vehicles);

        $("tbody").prepend("<tr class=\"vehicle_line\"><td class=\"liste_matricule\">"+matricule+"</td><td class=\"liste_marque\">"+marque+"</td><td class=\"liste_couleur\">"+couleur+"</td><td class=\"liste_type_vehicule\">"+type_vehicule+"</td><td class=\"liste_reference_boitier\">"+reference_boitier+"</td><td class=\"liste_type_boitier\">"+type_boitier+"</td><td class=\"liste_type_abonnement\">"+type_abonnement+"</td><td><input type=\"checkbox\" alt="+i+" class=\"checkbox\"></td></tr>");
        $("#matricule").val('');
        $("#couleur").val('');
        $("#type_vehicule").val('');
        $("#marque").val('');
        $("#reference_boitier").val('');
        $("#type_boitier").val('');
        $("#type_abonnement").val('');
        i++;
        }
    });
    $(".trash").click(function(){
        alert("x");
        $('#vehicles_table').find('input[type="checkbox"]:checked').each(function () {
            $( this ).parent().parent().remove();
        });
    });
    $(".edit_pencil").click(function(){

        $('#vehicles_table').find('input[type="checkbox"]:checked').each(function () {
            var lines=$( this ).parent().parent();
            $("#matricule").val(lines.children('.liste_matricule').text());
            $("#couleur").val(lines.children('.liste_couleur').text());
            $("#type_vehicule").val(lines.children('.liste_type_vehicule').text());
            $("#marque").val(lines.children('.liste_marque').text());
            $("#reference_boitier").val(lines.children('.liste_reference_boitier').text());
            $("#type_boitier").val(lines.children('.liste_type_boitier').text());
            $("#type_abonnement").val(lines.children('.liste_type_abonnement').text());
            var alt=$( this ).alt;
            delete vehicles.tab_matricule[alt];
            delete vehicles.tab_couleur[alt];
            delete vehicles.tab_marque[alt];
            delete vehicles.tab_type_boitier[alt];
            delete vehicles.tab_reference_boitier[alt];
            delete vehicles.tab_type_boitier[alt];
            delete vehicles.tab_type_abonnement[alt];
            lines.remove();
        });
    });

   $("#Add").click(function(){

       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       $.ajaxSetup({
           beforeSend: function(xhr, type) {
               if (!type.crossDomain) {
                   xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
               }
           },
       });
       $.ajax({
           type: 'POST',
           url: '/contract',

           data: { 'v':v , _token: CSRF_TOKEN},
           dataType: 'STRING',
           success: function (data) {
               console.log(data);
           },
           error : function(xhr, ajaxOptions, thrownError){
               console.log(xhr);
               console.log(thrownError);
           }
       });

   })
    $('#saveContrat :input').attr('disabled', true);
    $('#contrat :input').attr('disabled', true);
    $('#AddVehicles').click(function () {
        $('#saveContrat :input').attr('disabled', false);
        document.getElementById("saveContrat").style.opacity = "1";
        window.location.href = '#saveContrat';
        document.getElementById("contrat").style.opacity = "0.2";
        $('#contrat :input').attr('disabled', true);
    });
});
function addClient() {
    var nom = $("#nom").val();
    var city=$("#city").val();
    var phone=$("#phone").val();
    var mail=$("#mail").val();
    var type_client=$("#type_client").val();
    var contact=$("#contact").val();
    var ncontact=$("#ncontact").val();
    var address=$("#address").val();
    if(nom=="" || city=="" || phone=="" || mail=="" || type_client=="" || contact=="" || ncontact==""|| address=="" )
    {
        alert("Veuillez entrer tous les champs!");
    }
    else {
       // document.getElementById("client_form").action="/add";alert("2");
       // document.getElementById("add_client").type="submit";
        $('#contrat :input').attr('disabled', false);
        document.getElementById("contrat").style.opacity = "1";
        window.location.href = '#contrat';
        document.getElementById("client").style.opacity = "0.2";
        $('#client :input').attr('disabled', true);

    }
}
