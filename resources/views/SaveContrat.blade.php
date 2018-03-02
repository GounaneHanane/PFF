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
        <div class="container-fluid body" style="    margin-left: 22%;margin-right: 22%;">
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
	@endsection