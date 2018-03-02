@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/search.js"></script>
    <script  src="/js/delete.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">
        <div class="container-fluid body" style="margin-left: 0%;">
            <div class="panel">
                <div class="panel-heading">
                    <h3>Modifier le client</h3>
                </div>
                <div class="panel-body" style="    margin-top: 5%;">
                    <form class="form" onsubmit="event.preventDefault();" method="post">
                    <table id="client_info">
                        <tr>
                            <div class="form-group">
                                <td><label>Nom : </label></td>
                                <td><input type="text" name="" placeholder="Nom" class="form-control"></td><br>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td><label>Télèphone : </label></td>
                                <td><input type="text" name="" placeholder="Télèphone" class="form-control"></td><br>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td><label>Type de client : </label></td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" id="type_client">
                                            <option value="" disabled selected>Type de client</option>
                                            <option value="location">Location</option>
                                            <option value="personnel">Personnel</option>
                                        </select>
                                    </div>
                                </td>
                             </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td><label>Mail : </label></td>
                                <td><input type="text" name="" placeholder="Mail" class="form-control"></td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td><label>Ville : </label></td>
                                <td><input type="text" name="" placeholder="Ville" class="form-control"></td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td><label>Contact : </label></td>
                                <td><input type="text" name="" placeholder="Contact" class="form-control">	</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td><label>Tél contact: </label></td>
                                <td><input type="text" name="" placeholder="Tél Contact" class="form-control"></td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td><label>Adresse : </label></td>
                                <td><input type="text" name="" placeholder="Adresse" class="form-control"></td>
                            </div>
                        </tr>
                    </table>
                    <div>
                        <div class="edit">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="glyphicon glyphicon-pencil"></span>
                        </div>
                        <table class="table" id="vehicles_table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:11.11%">MATRICULE</th>
                                    <th class="text-center" style="width:11.11%">MARQUE</th>
                                    <th class="text-center" style="width:11.11%">MODEL</th>
                                    <th class="text-center" style="width:11.11%">TYPE DE VEHICULE</th>
                                    <th class="text-center" style="width:11.11%">IMEI</th>
                                    <th class="text-center" style="width:11.11%">MODEL DE BOITIER</th>
                                    <th class="text-center" style="width:11.11%">TYPE D'ABONNEMENT</th>
                                    <th class="text-center" style="width:11.11%">PRIX</th>
                                    <th class="text-center" style="width:11.11%">DATE D'AJOUT</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        @endsection