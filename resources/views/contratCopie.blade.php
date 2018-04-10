<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>


        #page { width:80%; margin:auto 10%; height:700px; }
        #logo { width:30%; height:100px; background:#ccc;}
        #infoHead { display:block;}
        #infoHead * { float:right; padding:1px; }
        #infoCompany { background:#fbfbfb; }
        #infoCompany * { padding-left:25px; padding-top:10px;  }
        #ContratContainer { width:100%; border:1px solid #000; height:700px; margin-top:50px; }
    </style>

</head>
<body>
     <div id="page" class="container">
             <div style="height:120px; " class="row">
                 <div class="col-sm-10">
                    <img src="http://opentech.ma/wp-content/uploads/2017/06/logo-website_new.png" id="logo" />
                 </div>
                 <div id="infoHead" class="col-sm-2">
                     <span style="font-weight:bold; font-size:15px; ">Fiche Contrat</span>
                     <span style="font-weight:bold; font-size:15px; ">Réf .: (PROV244)</span>
                     <span>Date : {{ date("Y-m-d")  }}</span>
                     <span>CodeClient:CU180209</span>

                 </div>
             </div>

         <div style="height:150px; margin-top:20px;   " class="row">
             <div id="infoCompany" class="col-sm-5">
                <h4>OPENTECH</h4>
                 <span>20-26 Rue Bassatines 1 er Etage N°4</span>
                 <br>
                 <span>20120 Casablanca</span>
                 <br>
                 <span>Tél : +212(0)522 30 90 90 - Fax: +212(0)522 31 90 90</span>
                 <br>
                 <span>Email : contact@opentech.ma</span>
                 <br>
                 <span>Web :www.opentech.ma</span>
             </div>
             <div style="border:1px solid #000; height:150px; margin-left:80px; padding-left:65px;" class="col-sm-6">
                <h3>AutoRiff</h3>
             </div>
         </div>

         <div  class="row">

             <div class="col-sm-12" id="ContratContainer">
         </div>


         </div>

         <div class="row" style="margin-top:50px;">


                 <div  style="  margin-left:30px; " class="col-sm-5">
                     <span>Pour OpenTech , nom et signature:</span>
                     <div style="border:1px solid #000; height:100px;">

                     </div>

                 </div>

             <div style=" height:150px; margin-left:80px; " class="col-sm-5">
                 <span>Pour AutoRif , nom</span>


                 <div style="border:1px solid #000; height:100px; padding-left:5px;">
                     et signature:
                 </div>
             </div>


         </div>

         <center>
             <div style="margin-bottom: 30px;">
                    <span>Capital de 500 000 MAD -R.C.:263465 -Patente: 322480519</span>
                    <br>
                    <span>I.F:14366774 - C.N.S.S .: 9211038 - ICE.:0000093194000039</span>
             </div>
         </center>
     </div>
</body>
</html>