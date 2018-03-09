@extends('layout')

@section('title', 'Client')

@section('import')
    @parent

    <link rel="stylesheet" href="/css/form.css"/>
    <script  src="/js/search.js"></script>
    <script  src="/js/delete.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/form.css">





    @endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="pull-left">Clients</h3>
                    <a  class="btn btn-primary pull-right"><span class="glyphicon glyphicon-refresh" id="refresh"></span></a>
                </div>

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="row">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">CLIENT</label>
                                            <select id="client_name" name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="" disabled selected >Veuillez selectionner un client</option>
                                                 @foreach($client as $c)
                                                     <option value="{{$c->name}}">{{ $c->name }}</option>

                                                 @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">VILLE</label>
                                            <input id="ville" type="text" class="form-control" name="matricule_searsh" placeholder="Ville" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">TYPE DE CLIENT</label>
                                            <select id="type_client" name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="" disabled selected>Veuillez selectionner un type</option>

                                                @foreach($type_client as $type)
                                                    <option value="{{$type->id}}">{{ $type->type }}</option>

                                                @endforeach

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
                            <div class="pull-right col-md-2 col-lg-3"><br>
                                <a href="/addClient" id="showmodal" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>NOUVEAU CLIENT</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="color: #2a4f7d;">
                                    <th class="text-center" style="width: 9.09%">NOM</th>
                                    <th class="text-center" style="width: 9.09%">VILLE</th>
                                    <th class="text-center" style="width: 9.09%">TELEPHONE</th>
                                    <th class="text-center" style="width: 9.09%">MAIL</th>
                                    <th class="text-center" style="width: 9.09%">TYPE DE CLIENT</th>
                                    <th class="text-center" style="width: 9.09%">CONTACT</th>
                                    <th class="text-center" style="width: 9.09%">TEL CONTACT</th>
                                    <th class="text-center" style="width: 9.09%">ADRESSE</th>
                                    <th class="text-center" style="width: 9.09%">NOMBRE DE VEHICULES</th>
                                    <th class="text-center" style="width: 9.09%">N°CONTRAT</th>


                                    <th class="text-center" style="width: 9.09%">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                @foreach ($client as $c)
                                    <tr id="{{ $c->id }}"  >



                                        <td class="text-center">{{ $c->name }}</td>
                                        <td class="text-center">{{ $c->city }}</td>
                                        <td class="text-center">{{ $c->phone }}</td>
                                        <td class="text-center">{{ $c->email }}</td>
                                        <td class="text-center">{{ $c->type }}</td>
                                        <td class="text-center">{{ $c->contact }}</td>
                                        <td class="text-center">{{$c->contact_phone }}</td>
                                        <td class="text-center"> {{ $c->address }} </td>
                                        <td class="text-center">{{ $c->vehicles }}</td>
                                        <td class="text-center">{{ $c->id_contract }}</td>

                                        <td class="text-center"><a class="btn btn-danger" > <span class="glyphicon glyphicon-trash edit trash " ></span></a>
                                            <a class=" btn btn-primary" href="/clientinfo/{{$c->name}}" id="edit_abonnement"><span class="glyphicon glyphicon-info-sign edit edit_pencil "></span></a></td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach

                                <?php ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection