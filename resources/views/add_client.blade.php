@extends('layout')

@section('title', 'Client')

@section('import')
    @parent

    <link rel="stylesheet" href="/css/form.css" />

    <script  src="http://localhost/js/recherche.js"></script>
    <script  src="http://localhost/js/supprimer.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">
        <div class="form">
            <h4>Ajouter un client</h4>


            <div class="form-group">
                <form action="/addclient" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="Nom" placeholder="Nom"  name="nom">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="vile" placeholder="Ville" name="prn">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="adresse" placeholder="Télèphone" name="adr">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="code_postal" placeholder="Mail" name="code_postal">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="type_client">
                            <option value="" disabled selected>Type de client</option>
                            <option value="location">Location</option>
                            <option value="personnel">Personnel</option>
                        </select>
                    </div>
<div class="form-group">
                    <input type="text" class="form-control" id="user" placeholder="Contact" name="user">
</div>
            <div class="form-group">
                <input type="text" class="form-control" id="number" placeholder="Tél Contact" name="number">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="number" placeholder="Adresse" name="number">
            </div>
            <center><button class="btn btn-info" type="submit">Ajouter</button></center>

            </form>
        </div>
        </div>
    </div>
@endsection