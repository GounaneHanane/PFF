@foreach($contracts as $c)

    <?php if($c->nbVehicles == 0)

        echo "<tr style='background-color: #f3d5aa' id='Contrat{{ $c->id_contract  }}'>";
    else if($c->nbVehicles!=$c->count)
        echo "<tr style='background-color: #f6f4ff' id='Contrat{{ $c->id_contract  }}'>";
    else echo "<tr id='Contrat{{ $c->id_contract  }}'>";
    ?>

    <td class="text-center"  >{{$c ->detail_matricule}}</td>

    <td class="text-center" >{{$c->start_contract}}</td>
    <td class="text-center">{{$c->end_contract}}</td>
    <td class="text-center" >{{$c->name}}</td>
    <td class="text-center" >{{ $c->type_customer}}</td>
    <td class="text-center" >{{$c->phone_number}}</td>
    <td class="text-center" class="nbvehicle">{{ $c->nbVehicles }}</td>
    <td class="text-center" class="nbvehicle">{{ $c->nbSimple }}</td>
    <td class="text-center"  class="nbvehicle">{{ $c->nbAvance }}</td>
    <td class="text-center" >{{$c->price}}</td>
    <td class="text-center" >
        @if($c->status == 1)
        <a class="btn btn-danger" onclick="disableContract({{$c->id_detail}})"  >
            <span class="glyphicon glyphicon-trash edit trash " ></span>
        </a>
        <a class="btn btn-info" onclick="window.open('/contrat/showdetails/{{$c->id_detail}}','_self')" >
            <span class="glyphicon glyphicon-info-sign "></span>
        </a>
        <a class=" btn btn-primary" data-toggle="modal" data-target="#editContratModal" id="edit_abonnement" onclick="editContratDialog({{$c->id_detail}})">
            <span class="glyphicon glyphicon-pencil edit edit_pencil "></span>
        </a>
        <a class="btn btn-success " data-toggle="modal" data-target="#RenContrat" onclick="renewal({{ $c->id_detail }})">
            <span class="glyphicon glyphicon-ok"  ></span>
        </a>
    </td>
    @else
        <td class="text-center" style="width:12.5%">
            <a class="btn btn-info" onclick="window.open('/contrat/showdetails/{{$c->id_detail}}','_self')" style="    width: 51%;
"  > <span class="glyphicon glyphicon-info-sign edit trash " ></span></a>
        </td>

        @endif

        </tr>
@endforeach




