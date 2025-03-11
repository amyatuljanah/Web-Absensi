<?php
session_start();

// Ambil data dari URL atau POST
$nama_siswa = $_GET['nama'] ?? $_POST['namaSiswa'] ?? '';
$status = $_GET['status'] ?? $_POST['aksi'] ?? '';
$hari = $_GET['hari'] ?? $_POST['hari'] ?? 'Senin';
$alasan = $_POST['alasan'] ?? '';

// Simpan status kehadiran di session
if ($nama_siswa && $status) {
    $_SESSION['status_kehadiran'][$hari][$nama_siswa] = $status;
    if ($status == 'Tidak Piket' && $alasan) {
        $_SESSION['alasan'][$hari][$nama_siswa] = $alasan;
    }
}

// Ambil data kehadiran dari session
$status_kehadiran = $_SESSION['status_kehadiran'] ?? [];
$alasan_kehadiran = $_SESSION['alasan'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Rekap Data Kehadiran Piket Kelas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-start min-h-screen pt-10">

    <h1 class="text-3xl font-bold mb-6">Rekap Data Kehadiran Piket Kelas</h1>

    <div class="mb-4">
        <label for="hari" class="block text-sm font-medium text-gray-700">Pilih Hari</label>
        <select id="hari" name="hari" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="changeDay(this.value)">
            <option value="Senin" <?= $hari == 'Senin' ? 'selected' : '' ?>>Senin</option>
            <option value="Selasa" <?= $hari == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
            <option value="Rabu" <?= $hari == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
            <option value="Kamis" <?= $hari == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
            <option value="Jumat" <?= $hari == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
        </select>
    </div>

    <table class="bg-white w-3/4 shadow-lg rounded-xl overflow-hidden">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="py-3 px-6 text-left">No</th>
                <th class="py-3 px-6 text-left">Nama Siswa</th>
                <th class="py-3 px-6 text-center">Status</th>
                <th class="py-3 px-6 text-left">Alasan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($status_kehadiran[$hari])) {
                echo "<tr><td colspan='4' class='py-4 px-6 text-center'>Belum ada data kehadiran</td></tr>";
            } else {
                $no = 1;
                foreach ($status_kehadiran[$hari] as $nama => $status) {
                    $alasan = $alasan_kehadiran[$hari][$nama] ?? '-';
                    echo "
                    <tr class='border-b'>
                        <td class='py-4 px-6'>" . $no++ . "</td>
                        <td class='py-4 px-6'>$nama</td>
                        <td class='py-4 px-6 text-center'>$status</td>
                        <td class='py-4 px-6'>$alasan</td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <script>
        function changeDay(hari) {
            window.location.href = 'admin1.php?hari=' + hari;
        }
    </script>

</body>
</html>