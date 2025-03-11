<?php
session_start();

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "presensi_siswa");

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari URL
$status = $_GET['status'] ?? '';
$nama_siswa = $_GET['nama'] ?? '';
$notif = $_GET['notif'] ?? '';

// Simpan status kehadiran di session jika status bukan 'Permintaan Persetujuan'
if ($nama_siswa && $status && $status !== 'Permintaan Persetujuan') {
    $_SESSION['status_kehadiran'][$nama_siswa] = $status;
}

// Query ambil data dari absensi_perpustakaan
$query = "SELECT nama_siswa, kelas, jurusan FROM absensi_perpustakaan";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Rekap Data Kehadiran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<!-- Main Content -->
<div class="p-8">
    <h2 class="text-2xl font-bold mb-6">Rekap Data Kehadiran</h2>

    <?php if ($status === 'Permintaan Persetujuan'): ?>
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Permintaan Persetujuan!</strong>
            <span class="block sm:inline">Siswa <?= htmlspecialchars($nama_siswa); ?> meminta persetujuan untuk mengubah status menjadi 'Tidak Hadir'.</span>
            <div class="mt-4">
                <a href="admin.php?nama=<?= htmlspecialchars($nama_siswa); ?>&status=Tidak Hadir&notif=Disetujui" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Setujui</a>
                <a href="admin.php?notif=Ditolak" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Tolak</a>
            </div>
        </div>
    <?php elseif ($notif): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Notifikasi!</strong>
            <span class="block sm:inline">Status kehadiran siswa telah diubah menjadi <?= htmlspecialchars($notif); ?>.</span>
        </div>
    <?php endif; ?>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">No</th>
                <th class="py-2 px-4 border-b text-left">Nama Siswa</th>
                <th class="py-2 px-4 border-b text-center">Kelas</th>
                <th class="py-2 px-4 border-b text-center">Jurusan</th>
                <th class="py-2 px-4 border-b text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $current_status = $_SESSION['status_kehadiran'][$row['nama_siswa']] ?? 'Belum Diketahui';
                    echo "<tr>
                        <td class='py-2 px-4 border-b'>{$no}</td>
                        <td class='py-2 px-4 border-b'>{$row['nama_siswa']}</td>
                        <td class='py-2 px-4 border-b text-center'>{$row['kelas']}</td>
                        <td class='py-2 px-4 border-b text-center'>{$row['jurusan']}</td>
                        <td class='py-2 px-4 border-b'>{$current_status}</td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Data tidak ditemukan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>

<?php mysqli_close($koneksi); ?>