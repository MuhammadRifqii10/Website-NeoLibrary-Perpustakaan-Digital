<?php
require_once '../dompdf/autoload.inc.php'; // path folder dompdf
use Dompdf\Dompdf;

include '../koneksi.php';

// Ambil data user
$query = "SELECT id_user, nama_user, email, tanggal_daftar FROM tb_user ORDER BY id_user DESC";
$result = mysqli_query($conn, $query);

// Buat HTML untuk PDF dengan styling
$html = '
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
</style>
</head>
<body>
    <h2>Daftar User Terdaftar</h2>
    <table>
        <thead>
            <tr>
                <th>ID User</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>';

while($row = mysqli_fetch_assoc($result)){
    $html .= '<tr>
                <td>'.$row['id_user'].'</td>
                <td>'.htmlspecialchars($row['nama_user']).'</td>
                <td>'.htmlspecialchars($row['email']).'</td>
                <td>'.$row['tanggal_daftar'].'</td>
              </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Buat objek DOMPDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Set ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Download PDF
$dompdf->stream('data_user.pdf', ["Attachment" => true]);
exit();
