@foreach($contracts as $c)
    <tr id="Contrat{{ $c->id_contract  }}">
        <td class="text-center" style="width: 11.11%" >{{$c ->id_contract}}</td>
        <td class="text-center" style="width: 11.11%">{{$c->start_contract}}</td>
        <td class="text-center" style="width: 12.5%">{{$c->end_contract}}</td>
        <td class="text-center" style="width: 11.11%">{{$c->name}}</td>
        <td class="text-center" style="width: 12.5%">{{ $c->type_customer }}</td>
        <td class="text-center" style="width: 11.11%">{{$c->contact}}</td>
        <td class="text-center" style="width: 11.11%">{{$c->phone_number}}</td>
        <td class="text-center" style="width: 11.11%">{{ $c->numberVehicles }}</td>
        <td class="text-center" style="width: 11.11%"><a class="btn btn-danger" onclick="disableContract({{$c->id_contract}})"   > <span class="glyphicon glyphicon-trash edit trash " ></span></a>
            <a class=" btn btn-primary" id="edit_abonnement"><span class="glyphicon glyphicon-pencil edit edit_pencil "></span></a></td>
    </tr>
@endforeach