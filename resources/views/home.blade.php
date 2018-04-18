@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/contract.js"></script>

    <script src="/js/alert.js"></script>
    <link rel="stylesheet" href="/css/alerte.css"/>
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
                    <div class="form-group col-md-3">

                    <select id="alert" class="selectpicker">
                        <option value="7">Semaine</option>
                        <option value="15">15 jours</option>
                        <option value="30">1 mois</option>
                        <option value="90">3 mois</option>
                    </select>

                    </div>

                </div>
            </div>


            <div class="panel-body">
                <div class="table-div">
                    <table class="table table-bordered" id="vehicles_table">
                        <thead>
                        <tr>
                            <th class="text-center" style="width:12.5%">NOM</th>
                            <th class="text-center" style="width:12.5%">CONTACT</th>
                            <th class="text-center" style="width:12.5%">TEL CONTACT</th>
                            <th class="text-center" style="width:12.5%">ADRESSE</th>
                            <th class="text-center" style="width:12.5%">DATE DE FIN</th>
                            <th class="text-center" style="width:12.5%">PRIX</th>
                            <th class="text-center" style="width:12.5%">TailleDeParc</th>
                            <th class="text-center" style="width:12.5%">COCHER</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alert as $a)
                        <tr>
                            <td class="text-center" style="width:12.5%">{{$a->name}}</th>
                            <td class="text-center" style="width:12.5%">{{$a->contact}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->phone_number}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->adress}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->end_contract}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->price}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->park}}</td>

                            <td class="text-center" style="width:12.5%">
                                <a class="btn btn-success " data-toggle="modal" data-target="#RenContrat" onclick="renewal({{ $a->id }})">
                                    <span class="glyphicon glyphicon-ok"  ></span>
                                </a>
                                <a onclick="disableContract({{$a->id}})">
                                    <span class="btn btn-danger glyphicon glyphicon-trash"  style=" float: inherit;"></span>
                                </a>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        <div>
                            <label class="col-md-4 control-label">date début : </label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="datedR" name="datedR" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="form-group col-md-4" style="    width: 41%;margin-top: 3%">
                            <select multiple size="10" id="OldVehicles" name="OldVehicles" class="form-control">
                            </select>
                        </div>
                        <div class="form-group col-md-4" style="     margin-left: 43%; margin-top: -31%;" >
                            <button type="button" class="form-control" id="AllOut" style="width: 24%"><<</button>
                            <button type="button" class="form-control" id="OneOut" style="width:24%"><</button>
                            <button type="button" class="form-control" id="OneIn" style="width: 24%">></button>
                            <button type="button" class="form-control" href="#" id="AllIn" style="width: 24%">>></button>
                        </div>

                        <div class="form-group col-md-4" style="    width: 37%;margin-left: 57%;margin-top: -35%;">
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
    @endsection