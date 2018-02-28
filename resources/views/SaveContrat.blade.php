@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="http://localhost/js/recherche.js"></script>
    <script  src="http://localhost/js/supprimer.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">
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
                    <th>Matricule</th>
                    <th>Marque</th>
                    <th>Couleur</th>
                    <th>Type de vehicule</th>
                    <th>Reference de boîtier</th>
                    <th>Type de boîtier</th>
                    <th>Type d'abonnement</th>
                    <th>Prix</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <center><button class="btn btn-info addBtn" onclick="window.open('clientInfo.html','_self');">Enregistrer</button></center>
        </form>
        </form>

    </div>
	@endsection