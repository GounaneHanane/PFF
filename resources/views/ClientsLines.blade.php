
@foreach ($client as $c)

    <tr id="{{ $c->id }}">

        <td>{{ $c->name }}</td>
        <td>{{ $c->city }}</td>
        <td>{{ $c->phone }}</td>
        <td>{{ $c->email }}</td>
        <td>{{ $c->type }}</td>
        <td>{{ $c->contact }}</td>
        <td>{{$c->contact_phone }}</td>
        <td> VIJIVJFIJIBJGIBJGIBJGI BJGIBJGIJBOIBJUHUTHUBH UBHGUBHUHBGHBUAAAAAA VVVUHVUHUF </td>
        <td>{{  $c->vehicles  }}</td>
        <td>{{ $c->id_contract }}</td>
        <td><input type="checkbox"></td>

    </tr>
@endforeach