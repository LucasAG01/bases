<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? 'Jugadores' }}</title>
  <style>
    body { margin:0; font-family: Arial, Helvetica, sans-serif; background:#ff8a72; }
    .wrap { width: 900px; margin: 0 auto; padding: 30px 0; }
    h1,h2 { text-align:center; margin: 10px 0 25px; }
    .card { background: rgba(255,255,255,0.12); padding: 18px; border-radius: 6px; }
    .row { display:flex; gap:20px; margin-bottom: 16px; }
    .col { flex:1; }
    label { display:block; margin-bottom:6px; }
    input, select { width:100%; padding:10px; border:0; border-radius:4px; }
    input[readonly]{ background:#eee; }
    .actions { display:flex; gap:12px; margin-top: 8px; }
    .btn { display:inline-block; padding:10px 14px; border-radius:4px; color:#fff; text-decoration:none; border:0; cursor:pointer; }
    .btn-primary{ background:#0d6efd; }
    .btn-success{ background:#198754; }
    .btn-info{ background:#0dcaf0; color:#00323a; }
    .btn-dark{ background:#495057; }
    .btn-gray{ background:#6c757d; }
    .msg-ok{ background:#d1e7dd; color:#0f5132; padding:10px 12px; border-radius:4px; margin: 10px 0 16px; }
    table{ width:100%; border-collapse:collapse; background:#2f343a; color:#fff; border-radius:6px; overflow:hidden; }
    th,td{ padding:12px 10px; border-bottom:1px solid rgba(255,255,255,.08); text-align:center; }
    th{ background:#212529; }
    .left { text-align:left; }
  </style>
</head>
<body>
  <div class="wrap">
    @yield('contenido')
  </div>
</body>
</html>
