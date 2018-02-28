
@foreach ($abonnement as $A)

    <tr id="{{ $A->id }}">

        <td>{{ $A->ClientType}}</td>
        <td>{{ $A->AbonnementType}}</td>
        <td>{{ $A->price }}</td>

        <td><input type="checkbox"></td>

    </tr>
@endforeach