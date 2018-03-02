@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <meta name="_token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/search.js"></script>
    <script  src="/js/delete.js"></script>
    <script  src="/js/add_contrat.js"></script>
@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <div class="container-fluid body" style="    margin-left: 22%;margin-right: 22%;">
        <div class="panel">
            <div class="panel-heading">
                <h4>Ajouter le contrat</h4>
            </div>
            <div class="panel-body">
                <div class="form" >
                    <form onsubmit="event.preventDefault();" method="post" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input type="text" class="form-control" id="contrat_save" placeholder="N°Contrat" name="cin">
                        </div>
                        <hr>
                        <div class="form-group">
                            <input type="text" class="form-control" id="matricule" placeholder="Matricule"  name="nom">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="matricule" placeholder="Marque"  name="nom">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="couleur" placeholder="Couleur" name="prn">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="type_vehicule">
                                <option value="" disabled selected>Type de vehicule</option>
                                <option value="transport" >Transport</option>
                            </select>
                        </div>
                        <hr>
                        <div class="form-group">
                            <input type="text" class="form-control" id="reference_boitier" placeholder="Réference de boitier" name="reference_boitier">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="type_boitier">
                                <option value="" disabled selected>Type de boîtier</option>
                                <option value="avance" >Avancé</option>
                            </select>
                        </div><hr>
                        <div class="form-group">
                            <select class="form-control" id="type_abonnement">
                                <option value="" disabled selected>Type d'abonnement</option>
                                <option value="lite">Lite</option>
                            </select>
                        </div>
                        <div class="form-group addcar">
                            <span class="glyphicon glyphicon-plus plus"></span> Ajouter une voiture
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
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection