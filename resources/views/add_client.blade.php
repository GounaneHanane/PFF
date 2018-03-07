@extends('layout')

@section('title', 'Client')

@section('import')
    @parent


    <link rel="stylesheet" href="/css/form.css" />


    <script  src="/js/delete.js"></script>
    <script  src="/js/search.js"></script>
    <script  src="/js/add_contrat.js"></script>
@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body active visible focus ready" style=" margin-left: 22%; margin-right: 22%;" id="client">
        <div class="panel">
            <div class="panel-heading">

            <h4>Ajouter un client</h4>

        </div>
            <div class="panel-body">
            <div class="form">
                                            <div class="form-group"  >
                                                <form id="client_form" method="POST" action="">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="nom" placeholder="Nom"  name="nom">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="city" placeholder="Ville" name="city">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="phone" placeholder="Télèphone" name="phone">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="mail" placeholder="Mail" name="mail">
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control" id="type_client">
                                                            <option value="" disabled selected>Type de client</option>
                                                            <option value="location">Location</option>
                                                            <option value="personnel">Personnel</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="contact" placeholder="Contact" name="contact">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="ncontact" placeholder="Tél Contact" name="NContact">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="address" placeholder="Adresse" name="address">
                                                    </div>
                                                   <center><button class="btn btn-info " id="add_client" type="button" OnClick="addClient()">Ajouter </button></center>

                                            </form>
                                        </div>
                                        </div>

            </div>
        </div>
    </div>
            <div  >
                <div class="container-fluid body active disabled" id="contrat"  style="opacity:0.2;margin-left: 22%;margin-right: 22%;">
                    <div class="panel" disabled="true">
                        <div class="panel-heading">
                            <h4>Ajouter le contrat</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form" >
                                <form action="" method="post" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="contrat_save" disabled placeholder="" name="cin" />

                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="matricule" placeholder="Matricule"  name="matricule">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="matricule" placeholder="Marque"  name="mark">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="couleur" placeholder="Modele" name="model">
                                    </div>

                                    <hr>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="reference_boitier" placeholder="Réference de boitier" name="reference_boitier">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="type_boitier" name="type_boitier">
                                            <option value="" disabled selected>Type de boîtier</option>
                                            <option value="avance" >Avancé</option>
                                        </select>
                                    </div><hr>
                                    <div class="form-group">
                                        <select class="form-control" id="type_abonnement" name="type_abonnement">
                                            <option disabled selected>Types Abonnements</option>

                                                <option value=""></option>

                                        </select>
                                    </div>
                                    <div class="form-group addcar" >
                                        <button class="btn btn-info" type="submit" id="Add" style="    width: 101%;"> <span class="glyphicon glyphicon-plus plus"></span> Ajouter une véhicule</button>
                                    </div>

                                    <div>
                                        <span class="glyphicon glyphicon-pencil edit edit_pencil" ></span>
                                        <span class="glyphicon glyphicon-trash edit trash "></span>
                                    </div>


                                    <div class="table-div">
                                        <table class="table table-bordered" id="vehicles_table">
                                            <thead>
                                            <tr>
                                                <th  class="text-center" style="width:12.5%">MATRICULE</th>
                                                <th class="text-center" style="width:12.5%">MARQUE</th>
                                                <th class="text-center" style="width:12.5%">MODEL</th>
                                                <th class="text-center" style="width:12.5%">TYPE DE VEHICULE</th>
                                                <th class="text-center" style="width:12.5%">IMEI</th>
                                                <th class="text-center" style="width:12.5%">MODEL DU BOÎTIER</th>
                                                <th class="text-center" style="width:12.5%">TYPE D'ABONNEMENT</th>
                                                <th class="text-center" style="width:12.5%">COCHER</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <center><button class="btn btn-info" id="AddVehicles" onclick="">Ajouter</button></center>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

    </div>
    </div>
    <div class="container-fluid body" id="saveContrat" style="opacity:0.2;    margin-left: 22%;margin-right: 22%;">
        <div class="panel">
            <div class="panel-heading">
                <h3>Enregistrer le contrat</h3>
            </div>
            <div class="panel-body">
                <form class="form " onsubmit="event.preventDefault();" method="post">
                    <div class="form-group col-sm-4">
                        <label>CIN : </label>
                        <label id="CIN"></label>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Nom : </label>
                        <label id="CIN"></label>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Prénom : </label>
                        <label id="CIN"></label>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>N°Contrat : </label>
                        <label id="contrat_show"></label>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Date de debut : </label>
                        <label id="CIN"></label>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Date de fin : </label>
                        <label id="CIN"></label>
                    </div>
                    <table class="table" id="vehicles_table">
                        <thead>
                        <tr>
                            <th  class="text-center" style="width:12.5%">MATRICULE</th>
                            <th class="text-center" style="width:12.5%">MARQUE</th>
                            <th class="text-center" style="width:12.5%">MODEL</th>
                            <th class="text-center" style="width:12.5%">TYPE DE VEHICULE</th>
                            <th class="text-center" style="width:12.5%">IMEI</th>
                            <th class="text-center" style="width:12.5%">MODEL DU BOÎTIER</th>
                            <th class="text-center" style="width:12.5%">TYPE D'ABONNEMENT</th>
                            <th class="text-center" style="width:12.5%">COCHER</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <center><button class="btn btn-info addBtn" onclick="window.open('clientInfo.html','_self');">Enregistrer</button></center>
                </form>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
    </script>
@endsection