@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css"/>
    <script  src="http://localhost/js/recherche.js"></script>
    <script  src="http://localhost/js/supprimer.js"></script>

    @endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">
        <div class="form">
            <h3><strong>La liste des clients</strong></h3>
            <div class="edit">
                <a ><span class="glyphicon glyphicon-plus" style=""></span></a>
                <span class="glyphicon glyphicon-trash trash" style=""></span>
                <span class="glyphicon glyphicon-refresh" id="refresh"></span>
            </div>

            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="form-group">
                        <table>
                            <form class="form" method="post" onclick="e.preventDefault()">
                                <select class="form-control col-sm-3" style=" width: 35%; margin-left: 4%;">
                                    <option value="matricule" disabled selected>Rechercher par --</option>
                                    <option value="nom">Nom</option>
                                    <option value="type_de_client">Type de client</option>
                                </select>
                                <input type="text" name="search" id="search_input" class="form-control col-sm-3" style=" width: 35%;     margin-left: 4%;" >
                                <button class="btn btn-info col-sm-3" type="button" id="search" style="width: 11%;     margin-left: 6%;">Rechercher</button>
                            </form>
                        </table>
                    </div>


                </div>
            </div>
            <table class="table" id="CustomerTable">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Ville</th>
                    <th>Télèphone</th>
                    <th>Mail</th>
                    <th>Type de client</th>
                    <th>Contact</th>
                    <th>Tél Contact</th>
                    <th>Adresse</th>
                    <th>Nombre de vehicule</th>
                    <th>N°Contrat</th>
                    <th></th>
                </tr>
                </thead>
               <tbody>
                @foreach ($client as $c)
                  <tr id="{{ $c->id }}" style="cursor: pointer;" onclick="window.open('http://127.0.0.1:8000/clients/{{$c->name}}/info/','_self');" >

                    <td>{{ $c->name }}</td>
                    <td>{{ $c->city }}</td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->type }}</td>
                    <td>{{ $c->contact }}</td>
                    <td>{{$c->contact_phone }}</td>
                     <td> VIJIVJFIJIBJGIBJGIBJGI BJGIBJGIJBOIBJUHUTHUBH UBHGUBHUHBGHBUAAAAAA VVVUHVUHUF </td>
                     <td>X</td>
                      <td>{{ $c->id_contract }}</td>
                      <td><input type="checkbox" id="checkCust"></td>
                  </tr>
                @endforeach
               </tbody>
            </table>
        </div>
    </div>
@endsection