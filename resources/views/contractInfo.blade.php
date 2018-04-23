@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <link rel="stylesheet" href="/css/modal.css" />
    <script  src="/js/contract.js"></script>

    <script src="/js/detail.js"></script>
    <script  src="/js/select.js"></script>

    <link rel="stylesheet" href="/css/select.css" />

    <style>
        b{
            font-size: 20px;
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

    <div class="body" alt="{{ $idContrat }}">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="pull-left">Vehicules</h3>
                    <div class="pull-right col-md-6 col-sm-6 col-xs-12 col-lg-6" style="text-align: right;">
                        <a  class="btn btn-primary pull-right" id="refreshDetail"><span class="glyphicon glyphicon-refresh" ></span></a>
                        @if( $contract->status  == 1)
                            <a id="AddDetailModal" type="button" data-toggle="modal" data-target="#addVehicleModal" class="btn btn-primary"><span class="	glyphicon glyphicon-plus"></span></a>
                        @endif
                        <a  class="btn btn-primary" onclick="window.open('/pdf/{{$contract->matricule}}')">
                            <span class="fa fa-file-pdf-o"></span>
                        </a>
                        <a  id="Rechercher" class="btn btn-primary menu-btn "><span class="	glyphicon glyphicon-search"></span> </a>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="row">
                                <form id="search_form" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">IMEI</label>
                                            <input id="imei" type="text" class="form-control" name="matricule_searsh" placeholder="IMEI" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">TYPE D'ABONNEMENT</label>
                                            <select id="type_abonnement" name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="0" disabled selected>Veuillez selectionner un type</option>
                                                @foreach($types_subscribes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Marque</label>
                                            <input id="marque" type="text" class="form-control" name="" placeholder="Marque" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Model</label>
                                            <input id="model" type="text" class="form-control" name="" placeholder="Model" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">DateAjout</label>
                                            <input id="dateAjout" type="date" class="form-control" name="matricule_searsh" placeholder="Date d'ajout" value="">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 pull-right" style="text-align: right; margin-right: 30px;">
                                            <button type="button" id="ContratInfosearch" class="btn btn-primary"><i class="fa fa fa-search" aria-hidden="true"></i> RECHERCHER</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="panel-heading clearfix">
                            <table>
                                @foreach($cli as $client )
                                    <tr>
                                    <td><b>{{$client->name}}</b></td>
                                    <td><b>{{$client->start_contract}}</b></td>
                                    <td><b>{{$client->end_contract}}</b><br></td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td><B>Total Vehicules : <span>{{ $contract->nbVehicles }}</span></b></td>
                                    <td><b>Nombre Avancé : <span>{{ $contract->nbAvance }}</span></b></td>
                                    <td><b>Nombre Simple : <span>{{ $contract->nbSimple }}</span></b></td>
                                </tr>
                            </table>





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


                                    @if( $contract->status  == 1)
                                        <th class="text-center" style="width: 9.09%">ACTIONS</th>
                                    @endif    
                                </tr>
                                </thead>
                                <tbody id="tableBody">
                                @foreach($details as $details)
                                    <tr style="color: #2a4f7d;" value="{{$details->id}}" id="line">
                                        <td id="Detail{{$details->id}}imei" class="text-center" style="width: 9.09%">{{$details -> imei}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$details -> marque}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$details -> model}}</td>
                                        <td id="Detail{{$details->id}}date" class="text-center" style="width: 9.09%">{{$details -> AddingDate}}</td>
                                        <td id="Detail{{$details->id}}type" class="text-center" style="width: 9.09%">{{$details -> typeSub}}</td>
                                        <td id="Detail{{$details->id}}price" class="text-center" style="width: 9.09%">{{$details -> price}}</td>
                                        <?php if($details->status==1)
                                           echo "<td class='text-center' style='width: 9.09%'><a class='btn btn-danger' onclick='disableDetail(".$details->id.")' > <span class='glyphicon glyphicon-trash edit trash '  ></span></a>
                                            <a class=' btn btn-primary' id='edit_detail'data-toggle='modal' data-target='#editVehicleModal' onclick='editDetail(".$details->id.")' ><span class='glyphicon glyphicon-pencil edit edit_pencil '></span></a>
                                        </td>
                                    ";?></tr>
                                @endforeach
                                </tbody>
                            </table>



                            <div class="modal fade" id="editVehicleModal" tabindex="-1" role="dialog" aria-labelledby="editVehicleModalTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title" id="editVehicleModalTitles">Modifier un vehicule</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="contrat" method="POST" class="form-horizontal">
                                                <input type="hidden" id="EditVehicleToken"   name="_token" value="{{ csrf_token() }}">
                                                <div class="form-group">

                                                        <label class="col-md-4 control-label">imei : </label>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" id="imeiId" name="imeiId" disabled >
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">date : </label>
                                                    <div class="col-md-6">
                                                    <input type="date" class="form-control" name="AddingDateEdit" id="AddingDateEdit" >
                                                    </div>
                                                </div>
                                                <div class="form-group"  style=" margin-bottom: -49px;">
                                                    <label class="col-md-4 control-label">type : </label>
                                                    <div class="col-md-6">
                                                    <select id="typesEdit" name="typesEdit" class="form-control">
                                                        <option  disabled selected id="defaultCli" value="0">Veuillez selectionner un type</option>
                                                        @foreach($types as $type)
                                                            <option value="{{$type->id}}">{{$type->type}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="margin-top: 64px;" >
                                                    <label class="col-md-4 control-label">prix : </label>
                                                    <div class="col-md-6">
                                                    <input type="text" id="priceVehiclesEdit" class="form-control" value="0" placeholder="Prix" >
                                                    </div>
                                                </div>

                                                <center style="      margin-top: 6%;"><button id="editVehicleBtn" class="btn btn-info" type="button"  >Enregistrer</button></center>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModalTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Ajouter un vehicule</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="contrat" class="form-horizontal" role="form" method="POST" >
                                            <input type="hidden" id="VehicleToken"   name="_token" value="{{ csrf_token() }}">


                                            <div class="form-group">
                                                <label class="col-md-4 control-label">imei : </label>
                                                <div class="col-md-6">
                                                    <select id="vehicules" name="vehicules" data-live-search="true" class="form-control  selectpicker">
                                                        <option  disabled selected id="defaultCli" value="0">Veuillez selectionner un vehicule</option>
                                                        @foreach($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}">{{$vehicle->imei}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">date d'ajout : </label>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control" name="AddingDate" value="{{ $date =  date('Y-m-d') }}" id="AddingDate" >
                                                </div>
                                            </div>
                                            <div class="form-group"  style=" margin-bottom: -49px;">
                                                <label class="col-md-4 control-label">type : </label>
                                                <div class="col-md-6">
                                                    <select id="types" name="types" class="form-control">
                                                        <option  disabled selected id="defaultCli" value="0">Veuillez selectionner un type</option>
                                                        @foreach($types as $type)
                                                            <option value="{{$type->id}}">{{$type->type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group" style="margin-top: 64px;">
                                                <label class="col-md-4 control-label">prix : </label>
                                                <div class="col-md-6">
                                                    <input type="text" id="priceVehicles" class="form-control" value="0" placeholder="Prix" >
                                                </div>
                                            </div>
                                            <center ><button id="addVehicleBtn2" class="btn btn-info" onclick="AddVeihcles({{ $idContrat}})" type="button"  >Enregistrer</button></center>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection