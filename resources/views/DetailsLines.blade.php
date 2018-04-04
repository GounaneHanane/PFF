@foreach($details as $details)
    <tr style="color: #2a4f7d;">
        <td class="text-center" style="width: 9.09%">{{$details -> imei}}</td>
        <td class="text-center" style="width: 9.09%">{{ $details->marque }}</td>
        <td class="text-center" style="width: 9.09%">{{ $details->model }}</td>
        <td class="text-center" style="width: 9.09%">{{ $details->AddingDate }}</td>
        <td class="text-center" style="width: 9.09%">{{$details -> type}}</td>
        <td class="text-center" style="width: 9.09%">{{$details -> price}}</td>
        <td class="text-center" style="width: 9.09%"><a class="btn btn-danger" onclick="disableDetail({{$details->id}},{{$details->id_contract}})" > <span class="glyphicon glyphicon-trash edit trash "  ></span></a>
            <a class=" btn btn-primary" id="edit_abonnement" ><span class="glyphicon glyphicon-pencil edit edit_pencil "></span></a></td>


        </td>
    </tr>
@endforeach