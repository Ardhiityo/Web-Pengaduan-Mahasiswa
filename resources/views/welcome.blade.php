<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan</title>
</head>

<body>
    <h1>Detail Laporan</h1>
    <p>Kode: <b>{{ $report->code }}</b></p>
    <p>Pelapor: <b>{{ $user }}</b></p>
    <p>Judul: <b>{{ $report->title }}</b></p>
    <p>Deskripsi: <b>{{ $report->description }}</b></p>
    <a href="{{ route('admin.report.show', $report->id) }}">disini</a>
</body>

</html>
