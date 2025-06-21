<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Hello {{ $nama }} - {{ $angka }}</h1>
    @if ($angka > 10)
        <h2>Angkanya besar</h2>
    @elseif ($angka > 5)
        <h2>Angkanya sedang</h2>
    @else
        <h2>Angkanya kecil</h2>
    @endif
</body>
</html>