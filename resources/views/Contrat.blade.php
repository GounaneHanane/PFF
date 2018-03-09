@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/delete.js"></script>
    <script  src="/js/abonnement.js"></script>
    <script  src="/js/chosen.js"></script>
    <style>
        #search_input
        {
            width: 17%;
            margin-left: 4%;
        }
    </style>
@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="pull-left">Contrats</h3>
                    <a class="btn btn-primary pull-right"><span class="glyphicon glyphicon-refresh" id="refresh"></span></a>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="row">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">N°CONTRAT</label>
                                            <input type="text" class="form-control" name="matricule_searsh" placeholder="N°Contrat" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">CLIENT</label>
                                            <select name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="0">Veuillez selectionner un client</option>
                                                <option value="0">1</option>
                                                <option value="0">2</option>
                                                <option value="0">3</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">DATE DE DEBUT</label>
                                            <input type="date" class="form-control" name="matricule_searsh" placeholder="" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">DATE DE FIN</label>
                                            <input type="date" class="form-control" name="matricule_searsh" placeholder="" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">TYPE DE CLIENT</label>
                                            <select name="costumer_search" class="form-control chosen-select" style="">
                                                <option value="0">Veuillez selectionner un type</option>
                                                <option value="0">1</option>
                                                <option value="0">2</option>
                                                <option value="0">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 pull-right" style="text-align: right; margin-right: 30px;">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa fa-search" aria-hidden="true"></i> RECHERCHER</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="panel-heading clearfix">
                            <div class="pull-right col-md-2 col-lg-3"><br>
                                <a href="/addcontrat" id="showmodal" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>NOUVEAU CONTRAT</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="color: #2a4f7d;">
                                    <th class="text-center" style="width: 12.5%" >N°CONTRAT</th>
                                    <th class="text-center" style="width: 12.5%">DATE DE DEBUT</th>
                                    <th class="text-center" style="width: 12.5%">DATE DE FIN</th>
                                    <th class="text-center" style="width: 12.5%">NOM</th>
                                    <th class="text-center" style="width: 12.5%">TYPE DE CLIENT</th>
                                    <th class="text-center" style="width: 12.5%">CONTACT</th>
                                    <th class="text-center" style="width: 12.5%">TEL CONTACT</th>
                                    <th class="text-center" style="width: 12.5%">NOMBRE DE VEHICULE</th>

                                    <th class="text-center" style="width: 12.5%">COCHER</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection