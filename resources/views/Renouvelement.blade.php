@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
        <link rel="stylesheet" href="/css/select.css" />


    <script  src="/js/delete.js"></script>
    <script  src="/js/abonnement.js"></script>
    <script  src="/js/select.js"></script>
    <script  src="/js/add_contract.js"></script>

    <script  src="/js/chosen.js"></script>


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
                    <h3 class="pull-left">Renouvelement</h3>
                    <a class="btn btn-primary pull-right"><span class="glyphicon glyphicon-refresh" id="refresh"></span></a>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                             <div class="row" id="status" alt="0">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">N°CONTRAT</label>
                                            <input id="mat" type="text" class="form-control" name="matricule_searsh" placeholder="N°Contrat" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">CLIENT</label>
                                            <select id="customer" name="costumer_search" data-live-search="true" class="selectpicker" style="">
                                                <option class="bs-title-option" value="">Veuillez selectionner un client</option>
                                                    @foreach($Customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                        @endforeach
                                            </select>
                                        </div>
                                        <div  class="form-group col-md-3">
                                            <label class="control-label">DATE DE DEBUT</label>
                                            <input id="debut_contrat" type="date" class="form-control" name="matricule_searsh" placeholder="" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">DATE DE FIN</label>
                                            <input id="fin_contrat" type="date" class="form-control" name="matricule_searsh" placeholder="" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">TYPE DE CLIENT</label>
                                            <select id="typeClient" name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="0">Veuillez selectionner un type</option>
                                                @foreach($clientTypes as $clientType)
                                                    <option value="{{ $clientType->ClientTypeId  }}">{{ $clientType->ClientType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 pull-right" style="text-align: right; margin-right: 30px;">
                                            <button id="recheche" type="button" class="btn btn-primary"><i class="fa fa fa-search" aria-hidden="true"></i> RECHERCHER</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="color: #2a4f7d;">
                                    <th class="text-center" style="width: 9.09%" >N°CONTRAT</th>
                                    <th class="text-center" style="width: 9.09%">DATE DE DEBUT</th>
                                    <th class="text-center" style="width: 9.09%">DATE DE FIN</th>
                                    <th class="text-center" style="width: 9.09%">NOM</th>
                                    <th class="text-center" style="width: 9.09%">TYPE DE CLIENT</th>
                                    <th class="text-center" style="width: 9.09%">CONTACT</th>
                                    <th class="text-center" style="width: 9.09%">TEL CONTACT</th>
                                    <th class="text-center" style="width: 9.09%">NOMBRE DE VEHICULE</th>
                                    <th class="text-center" style="width: 9.09%">NOMBRE DE SIMPLE</th>
                                    <th class="text-center" style="width: 9.09%">NOMBRE D'AVANCE</th>
                                    <th class="text-center" style="width: 9.09%">PRICE</th>
                                    <th class="text-center" style="width: 9.09%">Renouveler</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($archive as $a)
                                    <tr>
                                        <td class="text-center" style="width: 9.09%" >{{$a ->detail_matricule}}</td>

                                        <td class="text-center" style="width: 9.09%">{{$a->start_contract}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$a->end_contract}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$a->name}}</td>
                                        <td class="text-center" style="width:9.09%">{{ $a->type_customer}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$a->contact}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$a->phone_number}}</td>
                                        <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $a->nbVehicles }}</td>
                                        <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $a->nbSimple }}</td>
                                        <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $a->nbAvance }}</td>
                                        <td class="text-center" style="width:9.09%">{{$a->price}}</td>
                                        <td class="text-center" style="width:12.5%">
                                            <a class="btn btn-info" onclick="window.open('/contrat/showdetails/{{$a->id_detail}}','_self')" style="    width: 51%;
"  > <span class="glyphicon glyphicon-info-sign edit trash " ></span></a>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <dialog id="add_dialog"  class="abonnement_dialog add_dialog ">

        <div class="container-fluid body">
            <div class="panel">
                <div id="add_title">
                    <h4>Ajouter un abonnement</h4>
                </div>

                <div id="edit_title">
                    <h4>Modifier un abonnement</h4>
                </div>

                <div class="panel-body">
                    <div class="form" >

                        <form id="addOrEdit" method="POST" action="" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <select id="type_abonnement" name="type_abonnement" class="form-control">
                                    <option disabled selected id="defaultAbo">Type d'abonnement</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <select id="type_client" name="type_client" class="form-control">
                                    <option disabled selected id="defaultCli">Type de client</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="price" placeholder="Prix" name="price">
                            </div>
                            <center><button class="btn btn-info" id="addOrEditButton" onclick="addOrEdit();">Ajouter</button>

                            </center>
                        </form>
                        <center> <button class="btn btn-info" onclick="closeDialog()">Cancel</button></center>

                    </div>
                </div>
            </div>
        </div>

    </dialog>

    <script>

        var x = document.getElementById("add_dialog");

        function showDialog() {
            x.show();
        }

        function closeDialog() {
            x.close();
        }
    </script>
@endsection