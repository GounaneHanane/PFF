@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/delete.js"></script>
    <script  src="/js/abonnement.js"></script>
    <script  src="/js/add_contrat.js"></script>
    <style>
        b{
            font-size: 25px;
            margin-right: 57px;
        }
    </style>
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
                                            <label class="control-label">IMEI</label>
                                            <input id="ville" type="text" class="form-control" name="matricule_searsh" placeholder="IMEI" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">TYPE D'ABONNEMENT</label>
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
                            @foreach($cli as $client )
                            <b>{{$client->name}}</b>
                            <b>{{$client->start_contract}}</b>
                            <b>{{$client->end_contract}}</b>
                            @endforeach
                            <div class="pull-right col-md-2 col-lg-3"><br>
                                <a id="showmodal" onclick="document.getElementById('add_dialog').showModal();" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>NOUVEAU VEHICULE</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="color: #2a4f7d;">
                                    <th class="text-center" style="width: 9.09%">IMEI</th>
                                    <th class="text-center" style="width: 9.09%">MARQUE</th>
                                    <th class="text-center" style="width: 9.09%">MODEL</th>
                                    <th class="text-center" style="width: 9.09%">DATE D'AJOUT</th>
                                    <th class="text-center" style="width: 9.09%">TYPE D'ABONNEMENT</th>
                                    <th class="text-center" style="width: 9.09%">PRIX</th>
                                    <th class="text-center" style="width: 9.09%">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <thead>
                                @foreach($details as $details)
                                <tr style="color: #2a4f7d;" id="Detail{{$details->id}}">
                                    <td class="text-center" style="width: 9.09%">{{$details -> imei}}</td>
                                    <td class="text-center" style="width: 9.09%">{{$details -> marque}}</td>
                                    <td class="text-center" style="width: 9.09%">{{$details -> model}}</td>
                                    <td class="text-center" style="width: 9.09%">{{$details -> created_at}}</td>
                                    <td class="text-center" style="width: 9.09%">{{$details -> typeSub}}</td>
                                    <td class="text-center" style="width: 9.09%">{{$details -> price}}</td>
                                    <td class="text-center" style="width: 9.09%"><a class="btn btn-danger" onclick="disableDetail({{$details->id}})" > <span class="glyphicon glyphicon-trash edit trash "  ></span></a>
                                        <a class=" btn btn-primary" id="edit_abonnement" ><span class="glyphicon glyphicon-pencil edit edit_pencil "></span></a></td>


                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <dialog id="add_dialog"  class="abonnement_dialog add_dialog ">

                                <div class="container-fluid body">
                                    <div class="panel">
                                        <div id="add_title">
                                            <h4>Ajouter un vehicule</h4>
                                        </div>



                                        <div class="panel-body">
                                            <div class="form" >

                                                <form id="contrat" method="POST" >
                                                    <input type="hidden" id="ContratToken"   name="_token" value="{{ csrf_token() }}">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="contrat">
                                                    </div>

                                                    <div class="form-group">
                                                        <select id="vehicule" name="vehicule" class="form-control">
                                                            <option  disabled selected id="defaultCli" value="0">Veuillez selectionner un vehicule</option>
                                                            @foreach($vehicles as $vehicle)
                                                                <option value="{{$vehicle->id}}">{{$vehicle->imei}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select id="types" name="types" class="form-control" style=" width: 46%;margin-bottom: -49px;">
                                                            <option  disabled selected id="defaultCli" value="0">Veuillez selectionner un type</option>
                                                            @foreach($types as $type)
                                                                <option value="{{$type->id}}">{{$type->type}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group" style="  width: 42%;margin-left: 47%;margin-top: -49px;">

                                                        <input type="text" id="priceVehiclesAdvanced" class="form-control" value="0" placeholder="Prix" >

                                                    </div>
                                                    <div class="form-group" style="      width: 39%;margin-left: 55%;margin-top: -48px;">
                                                        <a id="ValidatePriceAdvanced"><span class="btn btn-success glyphicon glyphicon-ok" ></span></a>
                                                    </div>
                                                </form>

                                                <!--<form id="vehicles" method="POST">
                                                    <input type="hidden" id="GammeToken"   name="_token" value="{{ csrf_token() }}">
                                                    <div >

                                                        <div class="form-group" style="    width: 31%;    margin-bottom: -6%;">
                                                            <input type="Text" value="avance"  id="Advanced"disabled class="form-control">
                                                        </div>
                                                        <div class="form-group" style="    width: 31%;    margin-left: 31%;">
                                                            <input type="text"  class="form-control" id="nbVehiclesAdvanced" value="0" placeholder="Nombre des vehicules" >

                                                        </div>

                                                        <div class="form-group" style="    width: 31%;margin-left: 61%;margin-top: -49px;">

                                                            <input type="text" id="priceVehiclesAdvanced" class="form-control" value="0" placeholder="Prix" >

                                                        </div>
                                                        <div class="form-group" style="    width: 39%; margin-left: 62%;     margin-top: -48px;">
                                                            <a id="ValidatePriceAdvanced"><span class="btn btn-success glyphicon glyphicon-ok" ></span></a>
                                                        </div>
                                                    </div>
                                                    <div  style="margin-top: 10%;margin-bottom: 11%;">

                                                        <div class="form-group" style="    width: 31%;    margin-bottom: -6%;">
                                                            <input type="Text" value="simple" id="Simple" disabled class="form-control">

                                                        </div>
                                                        <div class="form-group" style="    width: 31%;    margin-left: 31%;">
                                                            <input type="text"  class="form-control" id="nbVehiclesSimple"  value="0" placeholder="Nombre des vehicules" >

                                                        </div>
                                                        <div class="form-group" style="    width: 31%;margin-left: 61%;margin-top: -49px;">
                                                            <input type="text" id="priceVehiclesSimple" class="form-control" value="0" placeholder="Prix" >
                                                        </div>
                                                        <div class="form-group" style="    width: 39%; margin-left: 62%;     margin-top: -48px;">
                                                            <a id="ValidatePriceSimple"><span class="btn btn-success glyphicon glyphicon-ok" ></span></a>
                                                        </div>
                                                    </div>-->

                                                    <center style="      margin-top: 6%;"><button class="btn btn-info" type="button" style="      margin-top: 9%; margin-left: 12%;" >Enregistrer</button></center>
                                                </form>
                                                <center> <button class="btn btn-info" id="" onclick="document.getElementById('add_dialog').close();">Cancel</button></center>
                                            </div>


                                        </div>




                                    </div>
                                </div>


                            </dialog>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection