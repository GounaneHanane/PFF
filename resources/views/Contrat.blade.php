@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/delete.js"></script>
    <script  src="/js/add_contrat.js"></script>
    <script  src="/js/chosen.js"></script>


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
                                            <input id="mat" type="text" class="form-control" name="matricule_searsh" placeholder="N°Contrat" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">CLIENT</label>
                                            <select id="customer" name="costumer_search" class="form-control chosen-select" style="">
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
                                <a onclick="document.getElementById('add_dialog').showModal();" id="showmodal" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>NOUVEAU CONTRAT</a>
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
                                    <th class="text-center" style="width: 9.09%">NOMBRE DE SIMPLE</th>
                                    <th class="text-center" style="width: 9.09%">NOMBRE D'AVANCE</th>

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
                                        <td class="text-center" style="width:9.09%">{{ $c->type_customer}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$c->contact}}</td>
                                        <td class="text-center" style="width: 9.09%">{{$c->phone_number}}</td>
                                        <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $c->nbVehicles }}</td>
                                        <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $c->nbSimple }}</td>
                                        <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $c->nbAvance }}</td>
                                        <td class="text-center" style="width:9.09%">{{$c->price}}</td>
                                        <td class="text-center" style="width:9.09%" class="etat">
                                            <?php if($c->nbVehicles == 0)  { echo "<h2 class='btn btn-warning'>En Cours</h2>";}
                                            else {echo "<h2 class='btn btn-info' style='width: 90%;'>Terminé</h2>"; }?>
                                        </td>
                                        <td class="text-center" style="width: 15%"><a class="btn btn-danger" onclick="disableContract({{$c->id_contract}})"   > <span class="glyphicon glyphicon-trash edit trash " ></span></a><a class="btn btn-info" onclick="window.open('/contrat/showdetails/{{$c->id_contract}}','_self')" style="    width: 51%;
"  > <span class="glyphicon glyphicon-info-sign edit trash " ></span></a>
                                            <a   class=" btn btn-primary" id="edit_abonnement" onclick="editContratDialog({{$c->id_contract}})"><span class="glyphicon glyphicon-pencil edit edit_pencil "></span></a></td>





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



                                    <div class="panel-body">
                                        <div class="form" >

                                            <form id="contrat" method="POST" >
                                                <input type="hidden" id="ContratToken"   name="_token" value="{{ csrf_token() }}">

                                                <div>
                                                    <input type="date" class="form-control" id="dated" name="dated" value="{{date('Y-m-d')}}">
                                                </div>
                                                <div class="form-group">
                                                    <select id="client" name="client" class="form-control">
                                                        <option  disabled selected id="defaultCli" value="0">Veuillez selectionner un client</option>
                                                        @foreach($Customers as $customer)
                                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                        @endforeach
                                                    </select>


                                                </div>

                                            </form>

                                            <form id="vehicles" method="POST">
                                                <input type="hidden" id="GammeToken"   name="_token" value="{{ csrf_token() }}">
                                                <div >

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                       <input type="Text" value="Avancé"  id="Advanced"disabled class="form-control">
                                                    </div>

                                             <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="number"  class="form-control" id="nbVehiclesAdvanced" value="0" min="0" step="1" >


                                                    </div>

                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">

                                                        <input type="text" id="priceVehiclesAdvanced" class="form-control"  placeholder="Prix" >

                                                    </div>
                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">
                                                        <input type="text"  class="form-control" id="nbVehiclesAdvanced" value="0" placeholder="Nombre des vehicules" >

                                                    </div>
                                                    <div class="form-group" style="    width: 39%; margin-left: 62%;     margin-top: -48px;">
                                                        <a id="ValidatePriceAdvanced"><span class="btn btn-success glyphicon glyphicon-ok" ></span></a>
                                                    </div>
                                                </div>
                                                <div  style="margin-top: 10%;margin-bottom: 11%;">

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                    <input type="Text" value="simple" id="Simple" disabled class="form-control">

                                                </div>

                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                    <input type="number" min="0" step="1"  class="form-control" id="nbVehiclesSimple"  value="0" placeholder="Nombre des vehicules" >

                                                </div>
                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">

                                                    <input type="text" id="priceVehiclesSimple" class="form-control" value="0" placeholder="Prix" >
                                                </div>
                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">
                                                        <input type="text"  class="form-control" id="nbVehiclesAdvanced" value="0" placeholder="Nombre des vehicules" >

                                                    </div>
                                                <div class="form-group" style="    width: 39%; margin-left: 62%;     margin-top: -48px;">
                                                    <a id="ValidatePriceSimple"><span class="btn btn-success glyphicon glyphicon-ok" ></span></a>
                                                </div>
                                        </div>

                                                <center><button class="btn btn-info" type="button" id="AddDetailGamme" >Enregistrer</button></center>
                                            </form>
                                            <center> <button class="btn btn-info" id="btnCancel" onclick="document.getElementById('add_dialog').close();">Cancel</button></center>
                                        </div>


                                    </div>




                                </div>
                            </div>


                        </dialog>


                            <dialog id="edit_dialog"  class="abonnement_dialog add_dialog ">

                                <div class="container-fluid body" >
                                    <div class="panel">

                                        <div id="edit_title">
                                            <h4>Modifier un abonnement</h4>
                                        </div>

                                        <div class="panel-body">
                                            <div class="form" >
                                                <form id="contrat" method="POST" >
                                                    <input type="hidden" id="ContratToken"  name="_token" value="{{ csrf_token() }}">

                                                    <div>
                                                        <input type="date" class="form-control" id="dated" name="dated">
                                                    </div>

                                                    <div class="form-group">

                                                        <select id="clientMaj" name="client" class="form-control" disabled>
                                                            <option  disabled selected id="defaultAbo" value="0">Veuillez selectionner un client</option>

                                                        </select>
                                                    </div>

                                                </form>
                                            <form id="addOrEdit" method="POST">
                                                <input type="hidden" id="ModifyGammeToken"   name="_token" value="{{ csrf_token() }}">

                                                <div >

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                        <input type="Text"   value="Avancé" disabled class="form-control">
                                                    </div>
                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="text"  class="form-control" id="ModifynbAdvancedVehicles" placeholder="Nombre des vehicules" >

                                                    </div>

                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">
                                                        <input type="text" id="ModifyPriceAdvanced" class="form-control"  placeholder="Prix" >

                                                    </div>

                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">

                                                        <input type="text" id="priceVehiclesSimple" class="form-control" value="0" placeholder="Prix" >
                                                    </div>
                                                    <div class="form-group" style="    width: 39%; margin-left: 62%;     margin-top: -48px;">
                                                        <a id="ModifyValidateAdvancedPrice"><span class="btn btn-success glyphicon glyphicon-ok" ></span></a>
                                                    </div>
                                                </div>
                                                <div  style="margin-top: 10%;margin-bottom: 11%;">

                                                    <div class="form-group" style="    width: 25%;    margin-bottom: -6%;">
                                                        <input type="Text" value="Simple" disabled class="form-control">

                                                    </div>
                                                    <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                                        <input type="text"  class="form-control" id="ModifynbSimpleVehicles" placeholder="Nombre des vehicules" >

                                                    </div>
                                                    <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">
                                                        <input type="text" id="ModifyPriceSimple" class="form-control"  placeholder="Prix" >
                                                    </div>
                                                    <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">

                                                        <input type="text" id="priceVehiclesSimple" class="form-control" value="0" placeholder="Prix" >
                                                    </div>
                                                    <div class="form-group" style="    width: 39%; margin-left: 62%;     margin-top: -48px;">
                                                        <a id="ModifyValidateSimplePrice"><span class="btn btn-success glyphicon glyphicon-ok" ></span></a>
                                                    </div>
                                                </div>
                                                <center><button class="btn btn-info" type="button" id="ModfiyContract">Modifier</button></center>
                                                </form>
                                                <center> <button class="btn btn-info" id="CancelContract"onclick="document.getElementById('edit_dialog').close();">Cancel</button></center>
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