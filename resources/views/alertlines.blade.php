@foreach($alert as $a)
    <tr>
        <td class="text-center" style="width:12.5%">{{$a->name}}</th>
        <td class="text-center" style="width:12.5%">{{$a->contact}}</td>
        <td class="text-center" style="width:12.5%">{{$a->phone_number}}</td>
        <td class="text-center" style="width:12.5%">{{$a->adress}}</td>
        <td class="text-center" style="width:12.5%">{{$a->end_contract}}</td>
        <td class="text-center" style="width:12.5%">{{$a->price}}</td>
        <td class="text-center" style="width:12.5%">{{$a->park}}</td>
        <td class="text-center" style="width:12.5%"><span class="btn btn-success glyphicon glyphicon-ok"    style=" float: inherit;"></span></td>
    </tr>
@endforeach