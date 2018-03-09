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
                    <a class="btn btn-primary pull-right"><span class="glyphicon glyphicon-refresh" id="refresh"></span></a>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="row">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">N°CONTRAT</label>
                                            <input type="text" class="form-control" name="matricule_searsh" placeholder="N°Contrat" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">CLIENT</label>
                                            <select name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="0">Veuillez selectionner un client</option>
                                                <option value="0">1</option>
                                                <option value="0">2</option>
                                                <option value="0">3</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">DATE DE DEBUT</label>
                                            <input type="date" class="form-control" name="matricule_searsh" placeholder="" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">DATE DE FIN</label>
                                            <input type="date" class="form-control" name="matricule_searsh" placeholder="" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">TYPE DE CLIENT</label>
                                            <select name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="0">Veuillez selectionner un type</option>
                                                <option value="0">1</option>
                                                <option value="0">2</option>
                                                <option value="0">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 pull-right" style="text-align: right; margin-right: 30px;">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa fa-search" aria-hidden="true"></i> RECHERCHER</button>
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
                                    <th class="text-center" style="width: 12.5%" >N°CONTRAT</th>
                                    <th class="text-center" style="width: 12.5%">DATE DE DEBUT</th>
                                    <th class="text-center" style="width: 12.5%">DATE DE FIN</th>
                                    <th class="text-center" style="width: 12.5%">NOM</th>
                                    <th class="text-center" style="width: 12.5%">TYPE DE CLIENT</th>
                                    <th class="text-center" style="width: 12.5%">CONTACT</th>
                                    <th class="text-center" style="width: 12.5%">TEL CONTACT</th>
                                    <th class="text-center" style="width: 12.5%">NOMBRE DE VEHICULE</th>

                                    <th class="text-center" style="width: 12.5%">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($contracts as $c)
                                        <tr>
                                <td class="text-center" style="width: 11.11%" >{{$c ->id}}</td>
                                <td class="text-center" style="width: 11.11%">{{$c->start_date}}</td>
                                <td class="text-center" style="width: 12.5%">{{$c->end_date}}</td>
                                <td class="text-center" style="width: 11.11%">{{$c->name}}</td>
                                <td class="text-center" style="width: 12.5%">TYPE DE CLIENT</td>
                                <td class="text-center" style="width: 11.11%">{{$c->contact}}</td>
                                <td class="text-center" style="width: 11.11%">{{$c->contact_phone}}</td>
                                <td class="text-center" style="width: 11.11%">{{$c->vehicles}}</td>
                                <td class="text-center" style="width: 11.11%"><a class="btn btn-danger" > <span class="glyphicon glyphicon-trash edit trash " ></span></a>
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

                                                <form id="addOrEdit" method="POST" action="" >
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="price" placeholder="N°Contrat" name="price">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" id="price" placeholder="Date de début" name="price">
                                                    </div>
                                                    <div class="form-group">
                                                        <select id="type_abonnement" name="type_abonnement" class="form-control">
                                                            <option disabled selected id="defaultAbo">Nom du client</option>
                                                            @foreach($contracts as $c)
                                                                <option id="type_client"  name="{{ $c->id_customer}}" value="{{$c->name}}">{{$c->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" id="newVehicleCombo" onclick=""> Nouveau vehicule
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
                                                            @foreach ($vehicle as $v)
                                                                <option id="type_abonnement"  name="{{ $v->id}}" value="{{ $v->car_number}}">{{ $v->car_number}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group" >
                                                        <select id="type_abonnement" name="type_abonnement" class="form-control">
                                                            <option disabled selected id="defaultAbo">Type d'abonnement</option>
                                                            @foreach ($abonnementTypes as $AbonnementType)
                                                                <option id="type_abonnement"  name="{{ $AbonnementType->AbonnementType}}" value="{{$AbonnementType->AbonnementTypeId}}">{{ $AbonnementType->AbonnementType}}</option>
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection