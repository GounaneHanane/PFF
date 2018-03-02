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
    <div class="container-fluid body">

                <div class="panel-body">

        <div class="panel">
            <div class="panel-heading">
                <div class="form">
                    <h3><strong>La liste des clients</strong></h3>
                </div>
                <div class="edit">
                    <a href="/addClient" ><span class="glyphicon glyphicon-plus" style=""></span></a>
                    <span class="glyphicon glyphicon-trash trash" style=""></span>
                    <span class="glyphicon glyphicon-refresh" id="refresh"></span>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <table>
                                <form class="form" method="post" onclick="e.preventDefault()">
                                    <select id="critiere" class="form-control col-sm-3" style=" width: 35%; margin-left: 4%;">
                                        <option value="matricule" disabled selected>Rechercher par --</option>
                                        <option value="nom">Nom</option>
                                        <option value="type_de_client">Type de client</option>
                                        <option value="city">ville</option>
                                    </select>
                                    <div class="">
                                        <input type="text" name="search" id="search_input" class="form-control col-sm-3" placeholder="Rechecher un nom" style=" width: 35%;  display:none;   margin-left: 4%;" />
                                        <select id="TypesClients"  class="form-control col-sm-3" style="display: none; width: 35%; margin-left: 4%;">
                                            <option disabled selected>Types Clients</option>
                                            @foreach($type_client as $type)
                                                <option value="{{$type->type}}">{{$type->type}}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" id="city_input" class="form-control col-sm-3"  placeholder="Rechercher par ville" style=" width: 35%;  display:none;   margin-left: 4%;" />

                                    </div>
                                    <button class="btn btn-info col-sm-3" type="button" id="search" style="width: 11%;     margin-left: 6%;">Rechercher</button>
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-div">
                <table class="table table-bordered" id="CustomerTable">
                    <thead>
                    <tr>
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
                      <tr id="{{ $c->id }}" style="cursor: pointer;"  >



                        <td class="text-center">{{ $c->name }}</td>
                        <td class="text-center">{{ $c->city }}</td>
                        <td class="text-center">{{ $c->phone }}</td>
                        <td class="text-center">{{ $c->email }}</td>
                        <td class="text-center">{{ $c->type }}</td>
                        <td class="text-center">{{ $c->contact }}</td>
                        <td class="text-center">{{$c->contact_phone }}</td>
                         <td class="text-center"> VIJIVJFIJIBJGIBJGIBJGI BJGIBJGIJBOIBJUHUTHUBH UBHGUBHUHBGHBUAAAAAA VVVUHVUHUF </td>
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
    </div></div>
@endsection