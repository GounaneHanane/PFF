@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
        <link rel="stylesheet" href="/css/select.css" />



    <script  src="/js/select.js"></script>
    <script  src="/js/contract.js"></script>




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
                    <div class="pull-right col-md-6 col-sm-6 col-xs-12 col-lg-6" style="text-align: right;">
                        <a class="btn btn-primary pull-right"><span class="glyphicon glyphicon-refresh" id="refresh"></span></a>
                        <a  id="Rechercher" class="btn btn-primary menu-btn "><i class="fa fa-plus-square" aria-hidden="true"></i><span class="	glyphicon glyphicon-search"></span> </a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                             <div class="row" id="status" alt="0">
                                <form id="search_form" style="display: none;">
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
                                    <th class="text-center" style="width:1%">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($archive as $a)
                                    <tr>
                                        <td class="text-center"  >{{$a ->detail_matricule}}</td>

                                        <td class="text-center" >{{$a->start_contract}}</td>
                                        <td class="text-center" >{{$a->end_contract}}</td>
                                        <td class="text-center" >{{$a->name}}</td>
                                        <td class="text-center" >{{ $a->type_customer}}</td>
                                        <td class="text-center" >{{$a->phone_number}}</td>
                                        <td class="text-center"  class="nbvehicle">{{ $a->nbVehicles }}</td>
                                        <td class="text-center"  class="nbvehicle">{{ $a->nbSimple }}</td>
                                        <td class="text-center"  class="nbvehicle">{{ $a->nbAvance }}</td>
                                        <td class="text-center" >{{$a->price}}</td>
                                        <td class="text-center" >
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



@endsection