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
                    <h3 class="pull-left">Abonnements</h3>
                    <a class="btn btn-primary pull-right"><span class="glyphicon glyphicon-refresh" id="refresh"></span></a>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="pull-right col-md-2 col-lg-3"><br>
                                <a href="#" id="showmodal" class="btn btn-primary" id="add_abonnement"  onclick="addType();"><i class="fa fa-plus-square" aria-hidden="true"></i>NOUVEAU ABONNEMENT</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width:16.66%">TYPE D'ABONNEMENT</th>
                                    <th class="text-center" style="width:16.66%">TYPE DE CLIENT</th>
                                    <th class="text-center" style="width:16.66%">PRIX</th>
                                    <th class="text-center" style="width:16.66%">NOMBRE DE VEHICULES</th>
                                    <th class="text-center" style="width:16.66%">COCHER</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($abonnement as $A)
                                    <tr value="{{ $A->id }}" style="cursor: pointer;" >


                                        <td class="text-center">{{ $A->ClientType}}</td>
                                        <td class="text-center">{{ $A->AbonnementType}}</td>
                                        <td class="text-center">{{ $A->price }}</td>
                                        <td class="text-center">{{$A->VehicleCount}}</td>
                                        <td class="text-center"><a class="btn btn-danger" href="{{URL::to('/deleteAbonnement/'.$A->id) }}"> <span class="glyphicon glyphicon-trash edit trash " ></span></a>
                                            <a class=" btn btn-primary"  id="edit_abonnement" onclick="ShowType('{{ $A->ClientTypeId}}','{{ $A->AbonnementTypeId}}','{{ $A->price }}');"><span class="glyphicon glyphicon-pencil edit edit_pencil "></span></a></td>
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
                                    @foreach ($abonnementTypes as $AbonnementType)
                                        <option id="type_abonnement"  name="{{ $AbonnementType->AbonnementType}}" value="{{$AbonnementType->AbonnementTypeId}}">{{ $AbonnementType->AbonnementType}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select id="type_client" name="type_client" class="form-control">
                                    <option disabled selected id="defaultCli">Type de client</option>
                                    @foreach ($clientTypes as $ClientType)
                                        <option id="type_client"  name="{{ $ClientType->ClientType}}" value="{{$ClientType->ClientTypeId}}">{{ $ClientType->ClientType}}</option>
                                    @endforeach
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