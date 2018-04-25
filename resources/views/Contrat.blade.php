@extends('layout')

@section('title', 'Contrat')

@section('import')
    @parent



    <link rel="stylesheet" href="/css/form.css" />
    <link rel="stylesheet" href="/css/select.css" />
    <script  src="/js/contract.js"></script>

    <script  src="/js/select.js"></script>
    <script  src="/js/alert.js"></script>

    <link rel="stylesheet" href="/css/alerte.css"/>



    <style>
        #search_input
        {
            width: 17%;
            margin-left: 4%;
        }

        #Detail*:hover { background:red; }
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
                    <div class="pull-right col-md-6 col-sm-6 col-xs-12 col-lg-6" style="text-align: right;">
                    <a class="btn btn-primary pull-right menu-btn" id="refresh" onclick="location.reload();" ><span class="glyphicon glyphicon-refresh " ></span></a>
                        <a  id="addContractModal" data-toggle="modal" data-target="#addContratModal" class="btn btn-primary menu-btn "><span class="	glyphicon glyphicon-plus"></span> </a>
                        <a  id="Rechercher" class="btn btn-primary menu-btn "><span class="	glyphicon glyphicon-search"></span> </a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="row" id="status" alt="1">
                                <form id="search_form" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <input id="mat" type="text" class="form-control" name="matricule_searsh" placeholder="N°Contrat" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <select id="customer" name="costumer_search" data-live-search="true" class="selectpicker" style="">
                                                <option class="bs-title-option" value="">Veuillez selectionner un client</option>
                                                    @foreach($Customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                        @endforeach
                                            </select>
                                        </div>

                                        <div  class="form-group col-md-3">
                                            <input id="debut_contrat" type="date" class="form-control datetimepicker" name="matricule_searsh" placeholder="" value="">
                                            <script>

                                            </script>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input id="fin_contrat" type="date" class="form-control" name="matricule_searsh" placeholder="" value="">
                                        </div>
                                        <div class="form-group col-md-3">
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
                            <table class="table table-bordered" id="contratTable">
                                <thead>
                                <tr style="color: #2a4f7d;">
                                    <th class="text-center" style="width: 12%" >N°CONTRAT</th>
                                    <th class="text-center" style="width: 9%">DATE DE DEBUT</th>
                                    <th class="text-center" style="width: 9%">DATE DE FIN</th>
                                    <th class="text-center" style="width: 0%">NOM</th>
                                    <th class="text-center" style="width: 0%">TYPE DE CLIENT</th>
                                    <th class="text-center" style="width: 13%">TEL CONTACT</th>
                                    <th class="text-center" style="width: 0%">N VEHICULE</th>
                                    <th class="text-center" style="width: 0%">N SIMPLE</th>
                                    <th class="text-center" style="width: 0%">N AVANCE</th>
                                    <th class="text-center" style="width: 0%">PRIX</th>
                                    <th class="text-center" style="width:17%">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contracts as $c)

                                <?php if($c->nbVehicles == 0)

                                echo "<tr style='background-color: #f3d5aa' id='Contrat{{ $c->id_contract  }}'>";
                                else if($c->nbVehicles!=$c->count)
                                    echo "<tr style='background-color: #f6f4ff' id='Contrat{{ $c->id_contract  }}'>";
                                else echo "<tr id='Contrat{{ $c->id_contract  }}'>";
                                    ?>

                                        <td class="text-center"  >{{$c ->detail_matricule}}</td>

                                        <td class="text-center" >{{$c->start_contract}}</td>
                                        <td class="text-center">{{$c->end_contract}}</td>
                                        <td class="text-center" >{{$c->name}}</td>
                                        <td class="text-center" >{{ $c->type_customer}}</td>
                                        <td class="text-center" >{{$c->phone_number}}</td>
                                        <td class="text-center" class="nbvehicle">{{ $c->nbVehicles }}</td>
                                        <td class="text-center" class="nbvehicle">{{ $c->nbSimple }}</td>
                                        <td class="text-center"  class="nbvehicle">{{ $c->nbAvance }}</td>
                                        <td class="text-center" >{{$c->price}}</td>
                                        <td class="text-center" >

                                            <a class="btn btn-danger" onclick="disableContract({{$c->id_detail}})"  >
                                                <span class="glyphicon glyphicon-trash edit trash " ></span>
                                            </a>
                                            <a class="btn btn-info" onclick="window.open('/contrat/showdetails/{{$c->id_detail}}','_self')" >
                                                <span class="glyphicon glyphicon-info-sign "></span>
                                            </a>
                                            <a class=" btn btn-primary" data-toggle="modal" data-target="#editContratModal" id="edit_abonnement" onclick="editContratDialog({{$c->id_detail}})">
                                                <span class="glyphicon glyphicon-pencil edit edit_pencil "></span>
                                            </a>
                                            <a class="btn btn-success " data-toggle="modal" data-target="#RenContrat" onclick="renewal({{ $c->id_detail }})">
                                                <span class="glyphicon glyphicon-ok"  ></span>
                                            </a>
                                            <a onclick="window.open('/pdf/contract/{{$c ->detail_matricule}}')" class="btn btn-danger" style=" ">
                                                <span class="fa fa-file-pdf-o"></span>
                                            </a>
                                        </td>





                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="modal fade" id="addContratModal" tabindex="-1" role="dialog" aria-labelledby="addContratModalTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title" id="addContratModalTitle">Ajouter un Contrat</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="contrat" method="POST"  class="form-horizontal" >
                                                <input type="hidden" id="ContratToken"   name="_token" value="{{ csrf_token() }}">

                                                <div>
                                                    <label class="col-md-4 control-label">Date début : </label>
                                                    <div class="col-md-6">
                                                    <input type="date" class="form-control" id="dated" name="dated" value="{{date('Y-m-d')}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Client : </label>
                                                    <div class="col-md-6">
                                                    <select id="client"  name="client" data-live-search="true" tabindex="-98" class="form-control selectpicker">
                                                        <option  disabled selected id="defaultCli" value="0">Veuillez selectionner un client</option>
                                                        @foreach($clients as $c)
                                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="col-md-4 control-label"> <span >Nombre de Vehicules :</span> </label>

                                                    <label class="col-md-4 control-label"> <span class="col-md-6" id="NbVehicles"></span></label>
                                        </div><br>
                                            </form>

                                            <form id="vehicles" method="POST">
                                                <input type="hidden" id="GammeToken"   name="_token" value="{{ csrf_token() }}">
                                                <div >

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                        <input type="Text" value="Avancé"  id="Advanced"disabled class="form-control">
                                                    </div>

                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="number"  class="form-control"  placeholder="Nombre des vehicules" id="nbVehiclesAdvanced" value="0" min="0" step="1" >


                                                    </div>

                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">

                                                        <input type="text" id="defaultAdvanced"  class="form-control"  placeholder="Defaut" >

                                                    </div>
                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">
                                                        <input type="text"  class="form-control" id="priceVehiclesAdvanced"  placeholder="Prix" >

                                                    </div>

                                                </div>
                                                <div  style="margin-bottom: 11%;">

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                        <input type="Text" value="simple" id="Simple" disabled class="form-control">

                                                    </div>

                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="number" min="0" step="1"  class="form-control" id="nbVehiclesSimple"  value="0" placeholder="Nombre des vehicules" >

                                                    </div>
                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">

                                                        <input type="text" id="defaultSimple" class="form-control"  placeholder="Defaut" >
                                                    </div>
                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">
                                                        <input type="text"  class="form-control" id="priceVehiclesSimple"  placeholder="Prix" >

                                                    </div>

                                                </div>

                                                <center><button class="btn btn-info" type="button" id="AddDetailGamme" >Enregistrer</button></center>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="editContratModal" tabindex="-1" role="dialog" aria-labelledby="editContratModalTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title" id="editContratModalTitle">Modifier un contrat</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" id="contrat" method="POST">
                                            <input type="hidden" id="ContratToken"  name="_token" value="{{ csrf_token() }}">

                                            <div>
                                                <label class="col-md-4 control-label">Date début : </label>
                                                <div class="col-md-6">
                                                <input type="date" class="form-control" id="datedModify" name="dated">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Client : </label>
                                                <div class="col-md-6">
                                                <select id="clientMaj" name="client" class="form-control" disabled>

                                                </select>
                                                </div>
                                            </div>
                                                <label class="col-md-4 control-label"> <span >Nombre de Vehicules :</span> </label>

                                            <label class="col-md-4 control-label"><span id="ModifyNbVehicles" alt=""></span></label>

                                            </form>
                                            <form id="addOrEdit" method="POST">
                                                <input type="hidden" id="ModifyGammeToken"   name="_token" value="{{ csrf_token() }}">

                                                <div >

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                        <input type="Text"   value="Avancé" disabled class="form-control">
                                                    </div>
                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="number"  class="form-control" id="ModifynbVehiclesAdvanced" value="0" min="0" step="1" >

                                                    </div>

                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">
                                                        <input type="text" id="ModifyDefaultAdvanced" class="form-control"  placeholder="Prix" >

                                                    </div>

                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">

                                                        <input type="text" id="ModifyPriceAdvanced" class="form-control" value="0" placeholder="Prix" >
                                                    </div>

                                                </div>
                                                <div  style="margin-bottom: 11%;">

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                        <input type="Text" value="Simple" disabled class="form-control">

                                                    </div>
                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="number" min="0" step="1"  class="form-control" id="ModifynbVehiclesSimple"  value="0" placeholder="Nombre des vehicules" >
                                                    </div>
                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">
                                                        <input type="text" id="ModifyDefaultSimple" class="form-control"  placeholder="Prix" >
                                                    </div>
                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">

                                                        <input type="text" id="ModifyPriceSimple" class="form-control" value="0" placeholder="Prix" >
                                                    </div>

                                                </div>
                                                <center><button class="btn btn-info" type="button" id="ModfiyContract">Modifier</button></center>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="RenContrat" tabindex="-1" role="dialog" aria-labelledby="RenContratTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title" id="RenContratTitle">Rouneveler un contrat</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="contrat" class="form-horizontal" method="POST">
                                                <input type="hidden" id="GammeToken"   name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" class="form-control" id="id_detail" name="id_detail" >
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Matricule : </label> <div id="lblMatricule"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Nom : </label> <div id="lblNom"></div>
                                                </div>

                                                <div>
                                                    <label class="col-md-4 control-label">Date début : </label>
                                                    <div class="col-md-6">
                                                    <input type="date" class="form-control" id="datedR" name="datedR" value="{{date('Y-m-d')}}">
                                                    </div>
                                                    </div>
                                                <div class="form-group col-md-4" style="    width: 41%;margin-top: 3%">
                                                    <label>Ancien véhicules</label><br>
                                                    <select multiple size="10" id="OldVehicles" name="OldVehicles" class="form-control">
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4" style="     margin-left: 43%; margin-top: -31%;" >
                                                    <button type="button" class="form-control" id="AllOut" style="width: 24%"><<</button>
                                                    <button type="button" class="form-control" id="OneOut" style="width:24%"><</button>
                                                    <button type="button" class="form-control" id="OneIn" style="width: 24%">></button>
                                                    <button type="button" class="form-control" href="#" id="AllIn" style="width: 24%">>></button>
                                                </div>

                                                <div class="form-group col-md-4" style="    width: 37%;margin-left: 57%;margin-top: -39%;">
                                                    <label>Nouveau véhicules</label>
                                                    <select multiple size="10" id="NewVehicles" name="NewVehicles" data-live-search="true" tabindex="-98" class="form-control">
                                                    </select>
                                                </div>

                                                <label class="col-md-4 control-label"><span >Nombre de Vehicules :</span></label>
                                                <label class="col-md-4 control-label"><span id="NbVehicles" alt="" ></span></label>

                                            </form>

                                            <form id="vehicles" method="POST">

                                                <div >

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -7%;">
                                                        <input type="Text" value="Avancé"  id="Advanced"disabled class="form-control">
                                                    </div>

                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="number"  class="form-control"  placeholder="Nombre des vehicules" id="nbVehiclesAdvancedR" value="0" min="0" step="1" >


                                                    </div>

                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">

                                                        <input type="text" id="defaultAdvancedR"  name="defaultAdvancedR" class="form-control"  placeholder="Defaut" >

                                                    </div>
                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">
                                                        <input type="text"  class="form-control" id="priceVehiclesAdvancedR" name="priceVehiclesAdvancedR"  placeholder="Prix" >

                                                    </div>

                                                </div>
                                                <div>

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                        <input type="Text" value="simple" id="Simple" disabled class="form-control">

                                                    </div>

                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="number" min="0" step="1"  class="form-control" id="nbVehiclesSimpleR"  value="0" placeholder="Nombre des vehicules" >

                                                    </div>
                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">

                                                        <input type="text" id="defaultSimpleR" class="form-control"  placeholder="Defaut" >
                                                    </div>
                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">
                                                        <input type="text"  class="form-control" id="priceVehiclesSimpleR"  placeholder="Prix" >

                                                    </div>

                                                </div>

                                                <center><button class="btn btn-info" type="button" id="AddRenGammeCC" >Enregistrer</button></center>
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