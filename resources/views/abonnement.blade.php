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
        <div class="form"  style="    margin-top: 23%;">
            <h3><strong>Les abonnements</strong></h3>
            <div>
                <span class="glyphicon glyphicon-pencil edit edit_pencil" id="edit_abonnement"></span>
                <span class="glyphicon glyphicon-trash edit trash "></span>
                <span class="glyphicon glyphicon-plus edit  " id="add_abonnement"></span>
            </div>
            <table class="table" id="vehicles_table">
                <thead>
                <tr>
                    <th>Type d'abonnement</th>
                    <th>Type de client</th>
                    <th>Prix</th>
                    <th>Nombre de clients</th>
                    <th>Nombre de vehicules</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($abonnement as $A)
                    <tr id="{{ $A->id }}" style="cursor: pointer;" >


                        <td>{{ $A->ClientType}}</td>
                        <td>{{ $A->AbonnementType}}</td>
                        <td>{{ $A->price }}</td>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox"></td>
                   <!-- </tr>-->
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <dialog id="add_dialog"  class="abonnement_dialog add_dialog">

        <div class="container-fluid body">
            <div class="form" >
                <h4>Ajouter une abonnement</h4>
                <form >
                    <div class="form-group">
                        <input type="text" class="form-control" id="type_abonnement" placeholder="Type d'abonnement" name="cin">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="type_client" placeholder="Type de client"  name="nom">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="prix" placeholder="Prix" name="prn">
                    </div>
                    <center><button class="btn btn-info" onclick="window.open('abonnements.html','_self');">Ajouter</button>
                        <button class="btn btn-info" id="add_cancel" >Cancel</button>
                    </center>
                </form>
            </div>
        </div>
    </dialog>
    <dialog id="edit_dialog"  class="abonnement_dialog edit_dialog">

        <div class="container-fluid body">
            <div class="form" >
                <h4>Modifier une abonnement</h4>
                <form >
                    <div class="form-group">
                       <select id="type_abonnement" class="form-control">
                           <option disabled selected>Type d'abonnement</option>
                           @foreach ($clientTypes as $ClientType)
                               <option>{{ $ClientType->ClientType}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class="form-group">
                        <select id="type_client" class="form-control">
                            <option disabled selected>Type de client</option>
                            @foreach ($abonnementTypes as $AbonnementType)
                                <option>{{ $AbonnementType->AbonnementType}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="prix" placeholder="Prix" name="prn">
                    </div>
                    <center><button class="btn btn-info" onclick="window.open('abonnements.html','_self');">Modifier</button>
                        <button class="btn btn-info" id="edit_cancel" >Cancel</button>
                    </center>
                </form>
            </div>
        </div>
    </dialog>
    <script>
        (function() {
            var addButton = document.getElementById('add_abonnement');
            var updateButton = document.getElementById('edit_abonnement');
            var EditCancelButton = document.getElementById('edit_cancel');
            var AddCancelButton = document.getElementById('add_cancel');
            // Update button opens a modal dialog
            updateButton.addEventListener('click', function() {
                document.getElementById('edit_dialog').showModal();
            });
            addButton.addEventListener('click', function() {
                document.getElementById('add_dialog').showModal();
            });
            // Bouton pour fermer la boîte de dialogue
            EditCancelButton.addEventListener('click', function() {
                document.getElementById('edit_dialog').close();
            });
            AddCancelButton.addEventListener('click', function() {
                document.getElementById('add_dialog').close();
            });
        })();
    </script>
  	@endsection