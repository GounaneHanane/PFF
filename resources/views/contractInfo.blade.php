@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/delete.js"></script>
    <script  src="/js/abonnement.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection
<script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
@section('content')
    <div class="body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="pull-left">Vehicules</h3>
                    <a  class="btn btn-primary pull-right"><span class="glyphicon glyphicon-refresh" id="refresh"></span></a>
                </div>

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="row">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">CLIENT</label>
                                            <select id="client_name" name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="" disabled selected >Veuillez selectionner un client</option>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">IMEI</label>
                                            <input id="ville" type="text" class="form-control" name="matricule_searsh" placeholder="IMEI" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">TYPE DE CLIENT</label>
                                            <select id="type_client" name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="" disabled selected>Veuillez selectionner un type</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 pull-right" style="text-align: right; margin-right: 30px;">
                                            <button type="button" id="search" class="btn btn-primary"><i class="fa fa fa-search" aria-hidden="true"></i> RECHERCHER</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="panel-heading clearfix">
                            <div class="pull-right col-md-2 col-lg-3"><br>
                                <a href="/addClient" id="showmodal" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>NOUVEAU VEHICULE</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="color: #2a4f7d;">
                                    <th class="text-center" style="width: 9.09%">IMEI</th>
                                    <th class="text-center" style="width: 9.09%">MARQUE</th>
                                    <th class="text-center" style="width: 9.09%">MODEL</th>
                                    <th class="text-center" style="width: 9.09%">MAIL</th>
                                    <th class="text-center" style="width: 9.09%">TYPE D'ABONNEMENT</th>
                                    <th class="text-center" style="width: 9.09%">PRIX</th>
                                    <th class="text-center" style="width: 9.09%">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection