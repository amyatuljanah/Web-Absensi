<?php
session_start();

// Ambil data dari POST
$nama_siswa = $_POST['nama'] ?? '';
$kelas = $_POST['kelas'] ?? '';
$jurusan = $_POST['jurusan'] ?? '';
$kategori = $_POST['kategori'] ?? $_GET['kategori'] ?? 'Kantin1';

// Simpan data piket kantin di session berdasarkan kategori
if ($nama_siswa && $kelas && $jurusan && $kategori) {
    $_SESSION['piket_kantin'][$kategori][] = [
        'nama' => $nama_siswa,
        'kelas' => $kelas,
        'jurusan' => $jurusan
    ];
    $_SESSION['notifikasi'] = "Absen telah berhasil";
    header("Location: admin2.php?kategori=$kategori");
    exit();
}

// Hapus data piket kantin
if (isset($_GET['hapus']) && isset($_GET['kategori'])) {
    $index = $_GET['hapus'];
    $kategori = $_GET['kategori'];
    if (isset($_SESSION['piket_kantin'][$kategori][$index])) {
        unset($_SESSION['piket_kantin'][$kategori][$index]);
        $_SESSION['piket_kantin'][$kategori] = array_values($_SESSION['piket_kantin'][$kategori]); // Reindex array
    }
}

// Ambil data piket kantin dari session berdasarkan kategori
$piket_kantin = $_SESSION['piket_kantin'][$kategori] ?? [];
$notifikasi = $_SESSION['notifikasi'] ?? '';
unset($_SESSION['notifikasi']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Rekap Data Piket Kantin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .notification {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            transition: top 0.5s;
        }
        .notification.show {
            top: 20px;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-start min-h-screen pt-10">

    <h1 class="text-3xl font-bold mb-6">Rekap Data Piket Kantin</h1>

    <?php if ($notifikasi): ?>
        <div id="notification" class="notification bg-green-500 text-white px-4 py-2 rounded-lg mb-4">
            <?= htmlspecialchars($notifikasi) ?>
        </div>
    <?php endif; ?>

    <div class="mb-4">
        <label for="kategori" class="block text-sm font-medium text-gray-700">Pilih Kantin</label>
        <select id="kategori" name="kategori" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="changeCategory(this.value)">
            <option value="Kantin1" <?= $kategori == 'Kantin1' ? 'selected' : '' ?>>Kantin 1</option>
            <option value="Kantin2" <?= $kategori == 'Kantin2' ? 'selected' : '' ?>>Kantin 2</option>
            <option value="Kantin3" <?= $kategori == 'Kantin3' ? 'selected' : '' ?>>Kantin 3</option>
            <option value="Kantin4" <?= $kategori == 'Kantin4' ? 'selected' : '' ?>>Kantin 4</option>
            <option value="Kantin5" <?= $kategori == 'Kantin5' ? 'selected' : '' ?>>Kantin 5</option>
            <option value="Kantin6" <?= $kategori == 'Kantin6' ? 'selected' : '' ?>>Kantin 6</option>
        </select>
    </div>

    <table class="bg-white w-3/4 shadow-lg rounded-xl overflow-hidden">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="py-3 px-6 text-left">No</th>
                <th class="py-3 px-6 text-left">Nama Siswa</th>
                <th class="py-3 px-6 text-left">Kelas</th>
                <th class="py-3 px-6 text-left">Jurusan</th>
                <th class="py-3 px-6 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($piket_kantin)) {
                echo "<tr><td colspan='5' class='py-4 px-6 text-center'>Belum ada data piket kantin</td></tr>";
            } else {
                $no = 1;
                foreach ($piket_kantin as $index => $data) {
                    echo "
                    <tr class='border-b'>
                        <td class='py-4 px-6'>" . $no++ . "</td>
                        <td class='py-4 px-6'>{$data['nama']}</td>
                        <td class='py-4 px-6'>{$data['kelas']}</td>
                        <td class='py-4 px-6'>{$data['jurusan']}</td>
                        <td class='py-4 px-6'>
                            <a href='admin2.php?hapus={$index}&kategori={$kategori}' class='bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700'>Hapus</a>
                        </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <script>
        function changeCategory(kategori) {
            window.location.href = 'admin2.php?kategori=' + kategori;
        }

        // Show notification
        document.addEventListener('DOMContentLoaded', function() {
            var notification = document.getElementById('notification');
            if (notification) {
                setTimeout(function() {
                    notification.classList.add('show');
                }, 100);
                setTimeout(function() {
                    notification.classList.remove('show');
                }, 3000);
            }
        });
    </script>

</body>
</html>