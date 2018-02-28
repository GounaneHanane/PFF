$(document).ready(function(){
    var vehicles={"tab_num_contart":$("#contrat_save").val(),"tab_matricule":[],"tab_couleur":[],"tab_type_vehicule":[],"tab_marque":[],"tab_type_abonnement":[],"tab_reference_boitier":[],"tab_type_boitier":[]};
    var car;
    var obj;
    var i=0;
    $(".addcar").click(function () {
        var matricule=$("#matricule").val();
        var couleur=$("#couleur").val();
        var type_vehicule=$("#type_vehicule").val();
        var marque=$("#marque").val();
        var reference_boitier=$("#reference_boitier").val();
        var type_boitier=$("#type_boitier").val();
        var type_abonnement=$("#type_abonnement").val();
        // if(matricule=="" || couleur=="" || type_vehicule=="" || marque=="" || reference_boitier=="" || type_abonnement=="" || type_boitier=="" )
        // {
        // 	alert("Veuillez entrer tous les champs!");
        // }
        // else
        // {
        //obj=JSON.parse(vehicles);
        vehicles.tab_matricule.push(matricule);
        vehicles.tab_couleur.push(couleur);
        vehicles.tab_type_vehicule.push(type_vehicule);
        vehicles.tab_marque.push(marque);
        vehicles.tab_type_abonnement.push(type_abonnement);
        vehicles.tab_reference_boitier.push(reference_boitier);
        vehicles.tab_type_boitier.push(type_boitier);
        $("tbody").prepend("<tr class=\"vehicle_line\"><td class=\"liste_matricule\">"+matricule+"</td><td class=\"liste_marque\">"+marque+"</td><td class=\"liste_couleur\">"+couleur+"</td><td class=\"liste_type_vehicule\">"+type_vehicule+"</td><td class=\"liste_reference_boitier\">"+reference_boitier+"</td><td class=\"liste_type_boitier\">"+type_boitier+"</td><td class=\"liste_type_abonnement\">"+type_abonnement+"</td><td><input type=\"checkbox\" alt="+i+" class=\"checkbox\"></td></tr>");
        $("#matricule").val('');
        $("#couleur").val('');
        $("#type_vehicule").val('');
        $("#marque").val('');
        $("#reference_boitier").val('');
        $("#type_boitier").val('');
        $("#type_abonnement").val('');
        i++;
        //}
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


});
