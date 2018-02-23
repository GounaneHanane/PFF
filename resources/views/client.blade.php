@extends('layout')

@section('title', 'Client')

@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid">
        <div class="form">
            <h4>Ajouter un client</h4>

            <!--
             <form method="post">



                -->
            <div class="form-group">
                <form method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="cin" placeholder="CIN" name="cin">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="Nom" placeholder="Nom"  name="nom">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="prenom" placeholder="Prénom" name="prn">
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="ville">
                            <option value="" disabled selected>Ville</option>
                            <option value="casablanca">Casablanca</option>
                            <option value="rabat">Rabat</option>
                            <option value="tanger">Tanger</option>
                            <option value="fes">Fes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="adresse" placeholder="Adresse" name="adr">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="code_postal" placeholder="Code postal" name="code_postal">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="number" placeholder="Numéro de téléphone" name="number">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="ville">
                            <option value="" disabled selected></option>
                            <option value="location">Location</option>
                            <option value="personnel">Personnel</option>
                        </select>
                    </div>
                    <input type="text" class="form-control" id="user" placeholder="Utilisateur" name="user">
                </form>
            </div>
            <center><button class="btn btn-info" onclick="window.open('addcontrat.html','_self')">Ajouter</button></center>

            </form>
        </div>
@endsection