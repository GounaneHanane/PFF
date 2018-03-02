@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/search.js"></script>
    <script  src="/js/delete.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">
        <div class="panel">
            <div class="panel-heading">
                <div class="form" style="margin-top: 0%;">
                    <h3><strong>Alerts d'expiration</strong></h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-div">
                    <table class="table table-bordered" id="vehicles_table">
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
        </div>
    </div>

    @endsection