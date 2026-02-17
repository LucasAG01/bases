@extends('plantillas.plantilla1')

@section('contenido')
  <h1>Listado de Jugadores</h1>

  @if (!empty($msg))
    <div class="msg-ok">{{ $msg }}</div>
  @endif

  <p>
    <a class="btn btn-success" href="fcrear.php">+ Nuevo Jugador</a>
  </p>

  <table>
    <thead>
      <tr>
        <th>Nombre Completo</th>
        <th>Posición</th>
        <th>Dorsal</th>
        <th>Código de Barras</th>
      </tr>
    </thead>
    <tbody>
      @foreach($jugadores as $j)
        <tr>
          <td class="left">{{ $j['apellidos'] }}, {{ $j['nombre'] }}</td>
          <td>{{ $j['posicion'] }}</td>
          <td>{{ $j['dorsal'] ?? 'Sin asignar' }}</td>
          <td>{{ $j['barcode'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
