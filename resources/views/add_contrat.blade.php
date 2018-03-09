@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <meta name="_token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/search.js"></script>
    <script  src="/js/delete.js"></script>
@endsection


@section('sidebar')
    @parent

@endsection



@section('content')
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <div class="body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="pull-left">Ajouter un contrat</h3>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
        <div class="panel">

            <div class="panel-body">
                <div class="form" >
                    <form method="post" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">


                        </div>

                            <div class="container-fluid body">
                                <div class="panel">


                                    <div class="panel-body">



                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-group">
                                                    <select id="nom_client" name="nom_client" class="form-control">
                                                        <option disabled selected>Nom du client</option>

                                                    </select>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="nContrat" placeholder="N°Contrat" name="nContrat">
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
                                                    <center><button class="btn btn-info" id="Add" onclick="">Ajouter</button></center>
                                                </div>

                                        </div>

                </div>
            </div>
                    </form>
        </div>


    </dialog>

    </div>
    </div>
    @endsection