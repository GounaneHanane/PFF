@extends('layout')

@section('title', 'Contrat')

@section('sidebar')
    @parent

@endsection

@section('content')
    <div class='container' id='VForm'>
        <h1>Ajout Contrat</h1>
        <form action="Command.php" method="post">
            <div class="form-group">
                <label for="Mat">N° command</label>
                <input type="text" class="form-control" id="Mat" name="commande">
            </div>
            <div class="form-group">
                <label for="Code">Cin</label>
                <input type="text" class="form-control" id="Code" name="cin">
            </div>



            <button type="submit" name="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
@endsection