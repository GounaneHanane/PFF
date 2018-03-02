@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <meta name="_token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/search.js"></script>
    <script  src="/js/delete.js"></script>
@endsection


@section('sidebar')
    @parent

@endsection



@section('content')
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <div class="container-fluid body" style="    margin-left: 22%;margin-right: 22%;">
        <div class="panel">
            <div class="panel-heading">
                <h4>Ajouter le contrat</h4>
            </div>
            <div class="panel-body">
                <div class="form" >
                    <form action="/contract/addVehicule/{{$id_contract}}" method="post" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input type="text" class="form-control" id="contrat_save" disabled placeholder="{{ $id_contract}}" name="cin" />

                        </div>
                        <hr>
                        <div class="form-group">
                            <input type="text" class="form-control" id="matricule" placeholder="Matricule"  name="matricule">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="matricule" placeholder="Marque"  name="mark">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="couleur" placeholder="Modele" name="model">
                        </div>

                        <hr>
                        <div class="form-group">
                            <input type="text" class="form-control" id="reference_boitier" placeholder="Réference de boitier" name="reference_boitier">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="type_boitier" name="type_boitier">
                                <option value="" disabled selected>Type de boîtier</option>
                                <option value="avance" >Avancé</option>
                            </select>
                        </div><hr>
                        <div class="form-group">
                            <select class="form-control" id="type_abonnement" name="type_abonnement">
                                <option disabled selected>Types Abonnements</option>
                            @foreach($types_subscribe as $type)
                                    <option value="{{$type->id}}">{{$type->type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group addcar" >
                            <button class="btn btn-info" type="submit" id="Add" style="    width: 101%;"> <span class="glyphicon glyphicon-plus plus"></span> Ajouter une véhicule</button>
                        </div>

                        <div>
                            <span class="glyphicon glyphicon-pencil edit edit_pencil" ></span>
                            <span class="glyphicon glyphicon-trash edit trash "></span>
                        </div>


                        <div class="table-div">
                            <table class="table table-bordered" id="vehicles_table">
                                <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Marque</th>
                                    <th>Couleur</th>
                                    <th>Type de vehicule</th>
                                    <th>Reference de boîtier</th>
                                    <th>Type de boîtier</th>
                                    <th>Type d'abonnement</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach($details as $detail)
                                     <tr>
                                         <td>{{$detail->car_number}}</td>
                                         <td>{{$detail->mark}}</td>
                                         <td>X</td>
                                         <td>X</td>
                                         <td>{{$detail->reference}}</td>
                                         <td>{{$detail->type_box}}</td>
                                         <td>{{$detail->type}}</td>
                                         <td><input type="checkbox" id="checkCont"/></td>
                                     </tr>
                                       @endforeach
                                </tbody>
                            </table>
                            <center><button class="btn btn-info" id="Add" onclick="">Ajouter</button></center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection