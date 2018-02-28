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

        <div class="form"  style="    margin-top: 23%;">
            <h3><strong>Alerts d'expiration</strong></h3>
            <table class="table" id="vehicles_table">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Télèphone</th>
                    <th>Contact</th>
                    <th>Tél de contact</th>
                    <th>Adresse</th>
                    <th>Date de fin</th>
                    <th>Prix</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @endsection