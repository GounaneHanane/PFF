@extends('layout')

@section('title', 'Client')

@section('import')
    @parent


    <link rel="stylesheet" href="/css/form.css" />


    <script  src="/js/delete.js"></script>
    <script  src="/js/search.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body" style="
    margin-left: 22%;
    margin-right: 22%;">
        <div class="panel">
            <div class="panel-heading">

            <h4>Ajouter un client</h4>

        </div>
            <div class="panel-body">
            <div class="form">
                                            <div class="form-group"  >
                                                <form action="/add" method="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="Nom" placeholder="Nom"  name="nom">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="vile" placeholder="Ville" name="city">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="adresse" placeholder="Télèphone" name="phone">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="code_postal" placeholder="Mail" name="mail">
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control" id="type_client">
                                                            <option value="" disabled selected>Type de client</option>
                                                            <option value="location">Location</option>
                                                            <option value="personnel">Personnel</option>
                                                        </select>
                                                    </div>
                                <div class="form-group">
                                                    <input type="text" class="form-control" id="user" placeholder="Contact" name="contact">
                                </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="number" placeholder="Tél Contact" name="NContact">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="number" placeholder="Adresse" name="number">
                                            </div>
                                           <center><button class="btn btn-info" type="submit">Ajouter</button></center>

                                            </form>
                                        </div>
                                        </div>

            </div>

    </div>
    </div>
@endsection