@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/delete.js"></script>
    <script  src="/js/add_contrat.js"></script>
    <script  src="/js/chosen.js"></script>
    <script src='jquery.min.js'></script>
    <script src='jquery-paginate.min.js'></script>
    <script src='js/omscontrat.js'></script>

    <style>
        #search_input
        {
            width: 17%;
            margin-left: 4%;
        }
    </style>
@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="pull-left">Contrats</h3>
                    <a class="btn btn-primary pull-right" id="refresh"><span class="glyphicon glyphicon-refresh" ></span></a>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="row">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">N°CONTRAT</label>
                                            <input id="matricule" type="text" class="form-control" name="matricule_searsh" placeholder="N°Contrat" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">CLIENT</label>
                                            <select id="client" name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="0">Veuillez selectionner un client</option>
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
                        <div class="panel-heading clearfix">
                            <div class="pull-right col-md-2 col-lg-3"><br>
                                <a onclick="addType();" id="showmodal" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>NOUVEAU CONTRAT</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered" id="contratTable">
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
                                    <th class="text-center" style="width: 9.09%">PRICE</th>
                                    <th class="text-center" style="width:9.09%">ETAT</th>
                                    <th class="text-center" style="width: 9.09%">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($contracts as $c)
                                    <tr id="Contrat{{ $c->id_contract  }}">
                                        <td class="text-center" style="width: 9.09%" >{{$c ->id_contract}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$c->start_contract}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$c->end_contract}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$c->name}}</td>
                                        <td class="text-center" style="width:9.09%">{{ $c->type_customer }}</td>
                                        <td class="text-center" style="width: 9.09%">{{$c->contact}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$c->phone_number}}</td>
                                        <td class="text-center" style="width: 9.09%">{{ $c->numberVehicles }}</td>
                                        <td class="text-center" style="width:9.09%"></td>
                                        <td class="text-center" style="width:9.09%"><h2 class="btn btn-warning">En Cours</h2></td>
                                        <td class="text-center" style="width: 9.09%"><a class="btn btn-danger" onclick="disableContract({{$c->id_contract}})"   > <span class="glyphicon glyphicon-trash edit trash " ></span></a>
                                            <a class=" btn btn-primary" id="edit_abonnement"><span class="glyphicon glyphicon-pencil edit edit_pencil "></span></a></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <dialog id="add_dialog"  class="abonnement_dialog add_dialog ">

                                <div class="container-fluid body">
                                    <div class="panel">
                                        <div id="add_title">
                                            <h4>Ajouter un Contrat</h4>
                                        </div>

                                        <div id="edit_title">
                                            <h4>Modifier un abonnement</h4>
                                        </div>

                                        <div class="panel-body">
                                            <div class="form" >

                                               <form id="contrat" method="POST" >
                                                        <input type="hidden" id="ContratToken"  name="_token" value="{{ csrf_token() }}">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="ncontrat" placeholder="N°Contrat" name="ncontrat">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="date" class="form-control" id="dated" placeholder="Date de début" name="dated">
                                                        </div>
                                                        <div class="form-group">
                                                            <select id="client" name="client" class="form-control">
                                                                <option  disabled selected id="defaultAbo" value="0">Veuillez selectionner un client</option>
                                                                @foreach($Customers as $customer)
                                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <center><button class="btn btn-info" id="addContratBtn" >Suivant</button></center>
                                                        </div>
                                               </form>
                                                <form id="addOrEdit" method="POST" action="" >
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div style="opacity: 0.2;" id="vehicles">
                                                        <div class="form-group">
                                                            <input type="checkbox" id="newVehicleCombo" onclick="addVehicle()"> Nouveau vehicule
                                                        </div>
                                                        <div class="form-group" id="newVehicle" style="display: none">
                                                            <input type="text" class="form-control">
                                                            <select class="form-control">
                                                                <option>WWW</option>
                                                                <?php
                                                                for($i = 'A'; $i <= 'Z'; $i++)
                                                                {echo "<option>".$i."</option>";}
                                                                ?>
                                                            </select>

                                                            <select class="form-control">
                                                                <option>WWW</option>
                                                                <?php
                                                                for($i = 1; $i < 100; $i++)
                                                                {echo "<option>".$i."</option>";}
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" id="selectVehicle">

                                                            <select id="type_abonnement" name="type_abonnement" class="form-control">
                                                                <option disabled selected id="defaultAbo">Matricule</option>

                                                            </select>
                                                        </div>
                                                        <div class="form-group" >
                                                            <select id="type_abonnement" name="type_abonnement" class="form-control">
                                                                <option disabled selected id="defaultAbo">Type d'abonnement</option>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="price" placeholder="Prix" name="price">
                                                        </div>
                                                        <center><button class="btn btn-info" id="addOrEditButton" onclick="addOrEdit();">Ajouter</button></center>
                                                    </div>
                                                </form>
                                                    </div>

                                                </form>
                                                <center> <button class="btn btn-info" onclick="closeDialog()">Cancel</button></center>

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