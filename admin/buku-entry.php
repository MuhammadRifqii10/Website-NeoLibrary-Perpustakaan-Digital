<form action="buku-proses.php" method="post" enctype="multipart/form-data">
  <label>Judul Buku</label>
  <input type="text" name="judul" required>

  <label>Penulis</label>
  <input type="text" name="penulis" required>

  <label>Kategori</label>
  <input type="text" name="kategori" required>

  <label>Upload Cover</label>
  <input type="file" name="cover" required>

  <button type="submit" name="simpan">Simpan</button>
</form>
