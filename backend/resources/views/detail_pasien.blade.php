<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar bg-success navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Rumah Sakit</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container pt-5">
        <div class="d-flex justify-content-between">
            <h3>Detail Pasien</h3>
            <a class="btn btn-primary" href="{{ url('/edit', [$pasien->id]) }}">
                <x-feathericon-edit />
            </a>
        </div>
        <div class="d-flex mt-5 justify-content-between">
            <div>
                <h5>Nama</h5>
                <p>{{ $pasien->nama }}</p>
            </div>
            <div>
                <h5>Tanggal lahir</h5>
                <p>{{ $pasien->tanggal_lahir }}</p>
            </div>
        </div>
        <div class="d-flex mt-3 justify-content-between">
            <div>
                <h5>NIK</h5>
                <p>{{ $pasien->nik }}</p>
            </div>
            <div>
                <h5>Alamat</h5>
                <p>{{ $pasien->alamat }}</p>
            </div>
        </div>
        <div class="mt-3">
            <h5>Gender</h5>
            <p>{{ $pasien->gender }}</p>
        </div>
        <h3 class="mt-5">Daftar Kunjungan</h3>
        @if ($pasien->reservations->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Perawatan</th>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pasien->reservations as $kunjungan)
                <tr>
                    <td>{{ $kunjungan->perawatan }}</td>
                    <td>{{ $kunjungan->tanggal }}</td>
                    <td>{{ $kunjungan->dokter }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Tidak ada riwayat kunjungan</p>
        @endif
    </div>

</body>