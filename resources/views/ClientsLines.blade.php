
@foreach ($client as $c)

    <tr id="{{ $c->id }}">

        <td class="text-center">{{ $c->name }}</td>
        <td  class="text-center">{{ $c->city }}</td>
        <td  class="text-center">{{ $c->phone }}</td>
        <td  class="text-center">{{ $c->email }}</td>
        <td  class="text-center">{{ $c->type }}</td>
        <td  class="text-center">{{ $c->contact }}</td>
        <td  class="text-center">{{$c->contact_phone }}</td>
        <td  class="text-center"> {{ $c->address }} </td>
        <td  class="text-center">{{  $c->vehicles  }}</td>
        <td  class="text-center">{{ $c->id_contract }}</td>
        <td class="text-center"><a class="btn btn-danger" > <span class="glyphicon glyphicon-trash edit trash " ></span></a>
            <a class=" btn btn-primary" href="/clientinfo/{{$c->name}}" id="edit_abonnement"><span class="glyphicon glyphicon-info-sign edit edit_pencil "></span></a></td>

    </tr>
@endforeach