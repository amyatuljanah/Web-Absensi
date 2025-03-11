<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "presensi_siswa");

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil kategori dari URL
$kategori = $_GET['kategori'] ?? '';

// Query ambil data dari absensi_perpustakaan
$query = "SELECT * FROM absensi_perpustakaan WHERE jurusan = '$kategori'";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<!-- Sidebar -->
<nav class="bg-[#3B3B58] text-white w-64 min-h-screen p-6 shadow-xl fixed">
    <h1 class="text-lg font-bold mb-6 flex items-center">
        <i class="fas fa-book mr-2"></i> Perpustakaan
    </h1>
    <ul class="space-y-4">
        <li><a href="dashboardsiswa.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
    </ul>
</nav>

<!-- Main Content -->
<div class="ml-72 p-8">
    <h2 class="text-2xl font-bold mb-6">Absensi Perpustakaan - <?= htmlspecialchars($kategori); ?></h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">No</th>
                <th class="py-2 px-4 border-b text-left">Nama Siswa</th>
                <th class="py-2 px-4 border-b text-center">Kelas</th>
                <th class="py-2 px-4 border-b text-center">Jurusan</th>
                <th class="py-2 px-4 border-b text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td class='py-2 px-4 border-b'>{$no}</td>
                        <td class='py-2 px-4 border-b'>{$row['nama_siswa']}</td>
                        <td class='py-2 px-4 border-b text-center'>{$row['kelas']}</td>
                        <td class='py-2 px-4 border-b text-center'>{$row['jurusan']}</td>
                        <td class='py-2 px-4 border-b'>
                            <a href='admin.php?nama={$row['nama_siswa']}&status=Hadir' class='text-green-500 hover:text-green-700 mr-4'><i class='fas fa-check-circle'></i> Hadir</a>
                            <a href='#' onclick='confirmTidakHadir(\"{$row['nama_siswa']}\")' class='text-red-500 hover:text-red-700'><i class='fas fa-times-circle'></i> Tidak Hadir</a>
                        </td>
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
<script>
function confirmTidakHadir(namaSiswa) {
    if (confirm("Apakah Anda yakin ingin mengubah status menjadi 'Tidak Hadir'?")) {
        window.location.href = 'admin.php?nama=' + namaSiswa + '&status=Permintaan Persetujuan';
    }
}
</script>
</body>
</html>

<?php mysqli_close($koneksi); ?>