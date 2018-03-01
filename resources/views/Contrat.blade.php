@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/delete.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">
        <div class="form">
            <h3 class="pull-left"><strong>La liste des contrats</strong></h3>
        </div>
        <div class="panel">
            <div class="panel-heading">
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
                                    <select class="form-control col-sm-3" style=" width: 35%; margin-left: 4%;">
                                        <option value="matricule" disabled selected>Rechercher par --</option>
                                        <option value="contrat">N°Contrat</option>
                                        <option value="date_debut">Date de debut</option>
                                        <option value="date_fin">Date de fin</option>
                                        <option value="type_de_client">Type de client</option>
                                        <option value="client">Nom du client</option>
                                    </select>
                                    <input type="text" name="search" id="search_input" class="form-control col-sm-3" style=" width: 35%;     margin-left: 4%;" >
                                    <button class="btn btn-info col-sm-3" type="button" id="search" style="width: 11%;     margin-left: 6%;">Rechercher</button>
                                </form>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <table class="table panel-body" id="CustomerTable">
                <thead>
                <tr>
                    <th class="text-center">N°Contart</th>
                    <th class="text-center">Date de debut</th>
                    <th class="text-center">Date de fin</th>
                    <th class="text-center">Nom</th>
                    <th class="text-center">Type de client</th>
                    <th class="text-center">Contact</th>
                    <th class="text-center">Tél Contact</th>
                    <th class="text-center">Nombre de vehicule</th>

                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection