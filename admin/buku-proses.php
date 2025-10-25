<?php
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $kategori = $_POST['kategori'];
    $cover = $_FILES['cover']['name'];

    echo 
    'Judul Buku : ' . $judul .
    '<br> Penulis : ' . $penulis .
    '<br> Kategori : ' . $kategori .
    '<br> Nama File : ' . $cover;
}
?>
