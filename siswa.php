<?php
session_start();
include 'config.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Tambah Siswa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_siswa'])) {
    $nis = $conn->real_escape_string($_POST['nis']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);
    $jurusan = $conn->real_escape_string($_POST['jurusan']);
    
    // Upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    } else {
        $foto = null;
    }

    // Cek apakah NIS sudah ada di tabel siswa
    $cekNIS = mysqli_query($conn, "SELECT nis FROM siswa WHERE nis = '$nis'");
    if (mysqli_num_rows($cekNIS) > 0) {
        echo "Error: NIS sudah terdaftar!";
    } else {
        $sql = "INSERT INTO siswa (nis, nama, kelas, jurusan, foto) VALUES ('$nis', '$nama', '$kelas', '$jurusan', '$foto')";
        if ($conn->query($sql) === TRUE) {
            header("Location: siswa.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Hapus Siswa
if (isset($_GET['delete_siswa'])) {
    $id = intval($_GET['delete_siswa']); // Menghindari SQL Injection
    $sql = "DELETE FROM siswa WHERE id=$id";
    $conn->query($sql);
}

// Ambil data siswa
$result = $conn->query("SELECT * FROM siswa");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-[#F0F4F8] text-gray-900 flex">
<nav class="bg-[#3B3B58] text-white w-64 min-h-screen p-6 shadow-xl flex flex-col">
        <h1 class="text-lg font-bold mb-6 flex items-center"><i class="fas fa-user-check mr-2"></i> Absensi Siswa</h1>
        <ul class="space-y-4 flex-grow">
            <li><a href="dashboard.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
            <li><a href="siswa.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-users mr-2"></i> Data Siswa</a></li>
            <li><a href="absensi.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-calendar-check mr-2"></i> Absensi</a></li>
        </ul>
        <a href="logout.php" class="block hover:text-gray-300 flex items-center mt-auto"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
    </nav>
    <div class="flex-1 p-6">
        <div class="bg-white shadow-lg p-6 rounded-lg border border-gray-200">
            <h2 class="text-2xl font-semibold mb-4 text-[#3B3B58] flex items-center"><i class="fas fa-users mr-2"></i> Data Siswa</h2>
            <form method="POST" enctype="multipart/form-data" class="mb-6">
                <input type="text" name="nis" placeholder="NIS" required class="border p-2 rounded mb-2 w-full">
                <input type="text" name="nama" placeholder="Nama Lengkap" required class="border p-2 rounded mb-2 w-full">
                <input type="text" name="kelas" placeholder="Kelas" required class="border p-2 rounded mb-2 w-full">
                <input type="text" name="jurusan" placeholder="Jurusan" required class="border p-2 rounded mb-2 w-full">
                <input type="file" name="foto" required class="border p-2 rounded mb-2 w-full">
                <button type="submit" name="add_siswa" class="bg-[#3B3B58] text-white p-2 rounded">Tambah Siswa</button>
            </form>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">NIS</th>
                        <th class="py-2 px-4 border-b text-left">Nama</th>
                        <th class="py-2 px-4 border-b text-left">Kelas</th>
                        <th class="py-2 px-4 border-b text-left">Jurusan</th>
                        <th class="py-2 px-4 border-b text-left">Foto</th>
                        <th class="py-2 px-4 border-b text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['nis']); ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['nama']); ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['kelas']); ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['jurusan']); ?></td>
                        <td class="py-2 px-4 border-b"><img src="uploads/<?= htmlspecialchars($row['foto']); ?>" alt="Foto Siswa" class="w-24 h-24 object-cover rounded"></td>
                        <td class="py-2 px-4 border-b"><a href="?delete_siswa=<?= intval($row['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?');" class="text-red-500 hover:text-red-700">Hapus</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>