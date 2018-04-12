@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/search.js"></script>
    <script  src="/js/add_contrat.js"></script>
    <script src="/js/alert.js"></script>
    <link rel="stylesheet" href="/css/alerte.css"/>
    <script  src="/js/chart.js"></script>
@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">
        <div class="panel">
            <div class="panel-heading">
                <div class="form" style="margin-top: 0%;">
                    <h3><strong>Alerts d'expiration</strong></h3>
                    <div class="form-group col-md-3">

                    <select id="alert" class="selectpicker">
                        <option value="7">Semaine</option>
                        <option value="15">15 jours</option>
                        <option value="30">1 mois</option>
                        <option value="90">3 mois</option>
                    </select>

                    </div>

                </div>
            </div>


            <div class="panel-body">
                <div class="table-div">
                    <table class="table table-bordered" id="vehicles_table">
                        <thead>
                        <tr>
                            <th class="text-center" style="width:12.5%">NOM</th>
                            <th class="text-center" style="width:12.5%">CONTACT</th>
                            <th class="text-center" style="width:12.5%">TEL CONTACT</th>
                            <th class="text-center" style="width:12.5%">ADRESSE</th>
                            <th class="text-center" style="width:12.5%">DATE DE FIN</th>
                            <th class="text-center" style="width:12.5%">PRIX</th>
                            <th class="text-center" style="width:12.5%">TailleDeParc</th>
                            <th class="text-center" style="width:12.5%">COCHER</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alert as $a)
                        <tr>
                            <td class="text-center" style="width:12.5%">{{$a->name}}</th>
                            <td class="text-center" style="width:12.5%">{{$a->contact}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->phone_number}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->adress}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->end_contract}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->price}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->park}}</td>

                            <td class="text-center" style="width:12.5%">
                                <a onclick="renewal({{ $a->id }})">
                                <span class="btn btn-success glyphicon glyphicon-ok"    style=" float: inherit;"></span>
                                </a>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
    </script>
    <canvas id="myChart" width="400" height="400"></canvas>
    <script src="path/to/chartjs/dist/Chart.js"></script>
    @endsection