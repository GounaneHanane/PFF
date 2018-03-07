
function addType()
{
    document.getElementById('add_dialog').showModal();
    document.getElementById("edit_title").style.display="none";
    document.getElementById("addOrEditButton").firstChild.data="Ajouter";
}
    function ShowType(typeClientId,typeAbonnmenetId,price) {

        document.getElementById('add_dialog').showModal();
        var tabAbonnement=document.getElementById("type_abonnement");
        var tabClient=document.getElementById("type_client");
        var tabClienttLength=tabClient.length;
      var tabAbonnementLength=tabAbonnement.length;
      document.getElementById("add_title").style.display="none";
        document.getElementById("addOrEditButton").firstChild.data="Modifier";
       for(var i=0;i<tabAbonnementLength;i++)
       {
           if(tabAbonnement[i].value==typeAbonnmenetId)
               tabAbonnement[i].selected=true;
       }
        for(var i=0;i<tabClienttLength;i++)
        {
            if(tabClient[i].value==typeClientId)
                tabClient[i].selected=true;
        }
        document.getElementById("price").value=price;
    }
function addOrEdit() {
    if(document.getElementById("addOrEditButton").firstChild.data=="Modifier")
    {

        document.getElementById("addOrEdit").action="updateAbonnement/";


    }
    else if(document.getElementById("addOrEditButton").firstChild.data=="Ajouter")
    {

        document.getElementById("addOrEdit").action="/add_type";
    }


}