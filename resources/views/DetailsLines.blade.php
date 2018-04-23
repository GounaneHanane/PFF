@foreach($details as $details)
    <tr style="color: #2a4f7d;" value="{{$details->id}}" id="line">
        <td id="Detail{{$details->id}}imei" class="text-center" style="width: 9.09%">{{$details -> imei}}</td>
        <td class="text-center" style="width: 9.09%">{{$details -> marque}}</td>
        <td class="text-center" style="width: 9.09%">{{$details -> model}}</td>
        <td id="Detail{{$details->id}}date" class="text-center" style="width: 9.09%">{{$details -> AddingDate}}</td>
        <td id="Detail{{$details->id}}type" class="text-center" style="width: 9.09%">{{$details -> type}}</td>
        <td id="Detail{{$details->id}}price" class="text-center" style="width: 9.09%">{{$details -> price}}</td>
        <?php if($details->status==1)
            echo "<td class='text-center' style='width: 9.09%'><a class='btn btn-danger' onclick='disableDetail(".$details->id.")' > <span class='glyphicon glyphicon-trash edit trash '  ></span></a>
                                            <a class=' btn btn-primary' id='edit_detail'data-toggle='modal' data-target='#editVehicleModal' onclick='editDetail(".$details->id.")' ><span class='glyphicon glyphicon-pencil edit edit_pencil '></span></a>

                                        </td>
                                    ";?></tr>
@endforeach