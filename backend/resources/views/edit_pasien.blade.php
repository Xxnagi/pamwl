<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit pasien</title>
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


    <div class="container mt-5">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="/data/input" method="post">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="nama">Nama</label>
                <input class="form-control" type="text" name="nama" value="{{ $pasien->nama }}">
            </div>
            <div class="form-group mt-2">
                <label for="tanggal_lahir">Tanggal lahir</label>
                <input class="form-control" type="date" name="tanggal_lahir" value="{{ $pasien->tanggal_lahir }}">
            </div>
            <div class="form-group mt-2">
                <label for="nik">NIK</label>
                <input class="form-control" type="number" name="nik" value="{{ $pasien->nik }}">
            </div>
            <div class="form-group mt-2">
                <label for="alamat">Alamat</label>
                <input class="form-control" type="text" name="alamat" value="{{ $pasien->alamat }}">
            </div>
            <div class="form-group mt-2">
                <label for="gender">Gender</label>
                <input class="form-control" type="text" pattern="[A-Za-z]{1}" name="gender" value="{{ $pasien->gender }}">
            </div>
            <div class="form-group mt-2">
                <input class="btn btn-primary" type="submit" value="Update">
            </div>
        </form>
    </div>
</body>