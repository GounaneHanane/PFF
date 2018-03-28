

@foreach($details as $detail)
<tr id="Detail{{$detail->id_detail}}" style="   cursor: pointer;" onclick="DetailSelected({{$detail->id_detail}})">

    <td>{{ $detail->imei  }}</td>
    <td>{{ $detail->type }}</td>
    <td >{{ $detail->price }}</td>
    <td><a onclick="disableDetail({{ $detail->id_detail }})">X</a></td>


</tr>
@endforeach