<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'Kelola Buku' }} - Admin Panel</title>
    <link rel="stylesheet" href="/css/admin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <aside class="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>
        <ul class="menu">
            <li><a href="/admin" class="menu-item"><i class="fas fa-home icon"></i><span class="text">Dashboard</span></a></li>
            <li><a href="/buku" class="menu-item active"><i class="fas fa-book icon"></i><span class="text">Kelola Buku</span></a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-user icon"></i><span class="text">Kelola User</span></a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-tags icon"></i><span class="text">Kelola Kategori</span></a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-heart icon"></i><span class="text">Kelola Favorit</span></a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-chart-bar icon"></i><span class="text">Laporan Aktivitas</span></a></li>
            <li><a href="/logout" class="menu-item"><i class="fas fa-sign-out-alt icon"></i><span class="text">Logout</span></a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <h1>Kelola Buku</h1>
            <p>Tambahkan, lihat, edit, dan hapus data buku yang tersimpan di sistem.</p>
            <a href="{{ route('buku.create') }}" class="aksi-btn">+ Tambah Buku Baru</a>
            <a href="{{ route('buku.cetak.pdf') }}" class="aksi-btn" style="background:#28a745;">
    <i class="fa fa-file-pdf"></i> Cetak PDF
</a>
        </header>

        <section class="table-section" style="margin-top:20px;">
            <h2>Daftar Buku Terdaftar</h2>

            <table id="tabel-buku">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php $no = 1; @endphp

                    @forelse ($data as $buku)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->penerbit }}</td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td>{{ $buku->stok }}</td>
                            <td>
                                <a href="{{ route('buku.edit', $buku->id_buku) }}" class="aksi-btn">Edit</a>

                                <form action="{{ route('buku.destroy', $buku->id_buku) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin menghapus buku {{ $buku->judul }}?')"
                                            class="aksi-btn hapus-btn">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7">Tidak ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>