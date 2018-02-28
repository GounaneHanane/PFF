@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="http://localhost/js/recherche.js"></script>
    <script  src="http://localhost/js/supprimer.js"></script>
    <script  src="http://localhost/js/add_contrat.js"></script>
@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/addContrats.js"></script>
    <div class="container-fluid body">
        <div class="form" >
            <h4>Ajouter le contrat</h4>
            <form onsubmit="event.preventDefault();" method="post" >
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

                <table class="table" id="vehicles_table">
                    <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Marque</th>
                        <th>Couleur</th>
                        <th>Type de vehicule</th>
                        <th>Reference de boîtier</th>
                        <th>Type de boîtier</th>
                        <th>Type d'abonnement</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <center><button class="btn btn-info" onclick="window.open('savecontrat.html','_self');">Ajouter</button></center>
            </form>
        </div>
    </div>
    @endsection