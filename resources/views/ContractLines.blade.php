@foreach($contracts as $c)

    <?php if($c->nbVehicles == 0)

        echo "<tr style='background-color: #f3d5aa' id='Contrat{{ $c->id_contract  }}'>";
    else if($c->nbVehicles!=$c->count)
        echo "<tr style='background-color: #f6f4ff' id='Contrat{{ $c->id_contract  }}'>";
    else echo "<tr id='Contrat{{ $c->id_contract  }}'>";
    ?>
    <tr id="Contrat{{ $c->id_contract  }}">
    <td class="text-center" style="width: 9.09%" >{{$c ->detail_matricule}}</td>

    <td class="text-center" style="width: 9.09%">{{$c->start_contract}}</td>
    <td class="text-center" style="width: 9.09%">{{$c->end_contract}}</td>
    <td class="text-center" style="width: 9.09%">{{$c->name}}</td>
    <td class="text-center" style="width:9.09%">{{ $c->type_customer}}</td>
    <td class="text-center" style="width: 9.09%">{{$c->contact}}</td>
    <td class="text-center" style="width: 9.09%">{{$c->phone_number}}</td>
    <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $c->nbVehicles }}</td>
    <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $c->nbSimple }}</td>
    <td class="text-center" style="width: 9.09%" class="nbvehicle">{{ $c->nbAvance }}</td>
    <td class="text-center" style="width:9.09%">{{$c->price}}</td>

    @if($c->status == 1)
            <td class="text-center" style="width: 15%">
                <a class="btn btn-danger" onclick="disableContract({{$c->id_detail}})"   > <span class="glyphicon glyphicon-trash edit trash " ></span></a><a class="btn btn-info" onclick="window.open('/contrat/showdetails/{{$c->id_detail}}','_self')" style="    width: 51%;
        "  > <span class="glyphicon glyphicon-info-sign edit trash " ></span></a>

                <a   class=" btn btn-primary" id="edit_abonnement" onclick="editContratDialog({{$c->id_contract}})"><span class="glyphicon glyphicon-pencil edit edit_pencil "></span></a>
            </td>
    @else
         <td class="text-center" style="width:12.5%">
                                            <a class="btn btn-info" onclick="window.open('/contrat/showdetails/{{$c->id_detail}}','_self')" style="    width: 51%;
"  > <span class="glyphicon glyphicon-info-sign edit trash " ></span></a>
                                        </td>

     @endif                                           





    </tr>
@endforeach