@extends('layout')

@section('title', 'Client')

@section('import')
@parent
    <link rel="stylesheet" href="http://localhost/form.css" />

    @endsection
@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid">

    <div class="form">
        <h4>La liste des clients</h4>
        <a href="addClient.html"><span class="glyphicon glyphicon-plus" style=""></span></a>
        <span class="glyphicon glyphicon-trash" style=""></span>

        <table class="table">
            <thead>
            <tr>
                <th>CIN</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Taille de parc</th>
                <th>Prix annuels</th>
                <th>N°Contrat</th>
            </tr>
            </thead>

            @foreach ($clients as $client)
              <tr>
                  <td>{{ $client->cin }}</td>
                  <td>{{ $client->name }}</td>
                  <td>{{ $client->contact }}</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td><input type="checkbox" /></td>
              </tr>
            @endforeach
        </table>
    </div>

    </div>


    @endsection