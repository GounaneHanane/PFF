@extends('layout')

@section('title', 'Client')

@section('sidebar')
    @parent

@endsection

@section('content')

    <div class="container-fluid">
        <form class="form ">
            <div class="form-group col-sm-4">
                <label>CIN : </label>
                <label id="CIN">{{ $client->cin }}</label>
            </div>
            <div class="form-group col-sm-4">
                <label>Nom : </label>
                <label id="CIN">{{ $client->name }}</label>
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
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <center><button class="btn btn-info" onclick="window.open('savecontrat.html','_self');">Enregistrer</button></center>
        </form>
        </form>

    </div>


@endsection