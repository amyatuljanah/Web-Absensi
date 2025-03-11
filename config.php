<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'presensi_siswa';

// Buat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data rekap absensi bulanan
$query = "SELECT status, COUNT(*) as jumlah FROM absensi WHERE MONTH(tanggal) = MONTH(CURRENT_DATE()) GROUP BY status";

$result = $conn->query($query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Inisialisasi array rekap absensi
$rekap_absensi = [
    'Hadir' => 0,
    'Izin' => 0,
    'Sakit' => 0,
    'Alpha' => 0,
    'Terlambat' => 0
];

// Isi data dari database jika ada
while ($row = $result->fetch_assoc()) {
    $rekap_absensi[$row['status']] = (int)$row['jumlah'];
}

// Jangan tutup koneksi di sini karena masih akan dipakai di halaman lain
?>
