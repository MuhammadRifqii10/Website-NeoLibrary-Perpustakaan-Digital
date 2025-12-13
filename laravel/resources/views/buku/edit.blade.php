<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Edit Buku' }} | Admin Panel</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <main class="main-content">
        <header>
            <h1>{{ $title ?? 'Edit Buku' }}</h1>
        </header>

        <section class="form-section">
            <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST" class="form-container" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label for="judul">Judul Buku</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required>

                <label for="penulis">Penulis</label>
                <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required>

                <label for="penerbit">Penerbit</label>
                <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required>

                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit" 
                       value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required 
                       min="1900" max="{{ date('Y') }}">

                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" required min="0">



                <button type="submit" class="aksi-btn" style="margin-top: 20px;">Simpan Perubahan</button>
                <a href="{{ route('buku.index') }}" class="aksi-btn batal-btn">Batal</a>
            </form>
        </section>
    </main>
</body>
</html>
