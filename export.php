<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "presensi_siswa");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Set header agar file bisa diunduh
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=absensi_siswa.csv");
header("Pragma: no-cache");
header("Expires: 0");

// Output header kolom CSV
$output = fopen("php://output", "w");
fputcsv($output, array("ID", "Nama", "Kelas", "Status", "Tanggal"));

// Ambil data dari database
$query = $koneksi->query("SELECT absensi.id, siswa.nama, siswa.kelas, absensi.status, absensi.tanggal 
                          FROM absensi 
                          JOIN siswa ON absensi.siswa_id = siswa.id");

// Tulis data ke dalam CSV
while ($row = $query->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
?>