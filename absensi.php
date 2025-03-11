<?php
// filepath: /c:/xampp/htdocs/presensi_siswa/absensi.php

session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Tambah Absensi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_absensi'])) {
    $siswa_id = mysqli_real_escape_string($conn, $_POST['siswa_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $sql = "INSERT INTO absensi (siswa_id, status, tanggal) VALUES ('$siswa_id', '$status', NOW())";
    if ($conn->query($sql) === TRUE) {
        header("Location: absensi.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus Absensi
if (isset($_GET['delete_absensi'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_absensi']);
    
    $sql = "DELETE FROM absensi WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: absensi.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Update Absensi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_absensi'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $sql = "UPDATE absensi SET status='$status' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: absensi.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Ambil Data Siswa & Absensi
$siswa_result = $conn->query("SELECT * FROM siswa");

// Ambil parameter filter dari URL
$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

// Buat query dasar dengan join tabel siswa
$query = "SELECT absensi.id, siswa.nis, siswa.nama, siswa.kelas, absensi.status, absensi.tanggal, siswa.foto 
          FROM absensi 
          JOIN siswa ON absensi.siswa_id = siswa.id 
          WHERE 1=1";

// Tambahkan kondisi filter jika ada
if ($nama != '') {
    $query .= " AND siswa.nama LIKE '%$nama%'";
}
if ($tanggal != '') {
    $query .= " AND DATE(absensi.tanggal) = '$tanggal'";
}
if ($status != '') {
    $query .= " AND absensi.status = '$status'";
}
if ($kelas != '') {
    $query .= " AND siswa.kelas = '$kelas'";
}

// Eksekusi query
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa</title>
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
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }
        select, button {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        select {
            background: white;
            cursor: pointer;
        }
        button {
            background: #2c2f5b;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #1f2244;
        }
        option {
            font-size: 16px;
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
            <h2 class="text-2xl font-semibold mb-4 text-[#3B3B58] flex items-center"><i class="fas fa-calendar-check mr-2"></i> Absensi Siswa</h2>
            <form method="POST" class="mb-6">
                <select name="siswa_id" required class="border p-2 rounded mb-2 w-full">
                    <option value="">Pilih Siswa</option>
                    <?php while ($row = $siswa_result->fetch_assoc()) { ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nis']) ?> - <?= htmlspecialchars($row['nama']) ?></option>
                    <?php } ?>
                </select>
                <select name="status" required class="border p-2 rounded mb-2 w-full">
                    <option value="Hadir">Hadir</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Terlambat">Terlambat</option>
                    <option value="Alpha">Alpha</option>
                    <option value="Izin">Izin</option>
                </select>
                <button type="submit" name="add_absensi" class="bg-[#3B3B58] text-white p-2 rounded">Tambah Absensi</button>
            </form>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">NIS</th>
                        <th class="py-2 px-4 border-b text-left">Nama Siswa</th>
                        <th class="py-2 px-4 border-b text-left">Kelas</th>
                        <th class="py-2 px-4 border-b text-left">Status</th>
                        <th class="py-2 px-4 border-b text-left">Tanggal</th>
                        <th class="py-2 px-4 border-b text-left">Foto</th>
                        <th class="py-2 px-4 border-b text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['nis']); ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['nama']); ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['kelas']); ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['status']); ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($row['tanggal']); ?></td>
                                <td class="py-2 px-4 border-b"><img src="uploads/<?= htmlspecialchars($row['foto']); ?>" alt="Foto Siswa" class="w-16 h-16 object-cover rounded"></td>
                                <td class="py-2 px-4 border-b">
                                    <a href="absensi.php?edit_absensi=<?= $row['id'] ?>" class="text-blue-500">Edit</a> |
                                    <a href="absensi.php?delete_absensi=<?= $row['id'] ?>" onclick="return confirm('Yakin?')" class="text-red-500">Hapus</a>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-4'>Tidak ada data ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <?php if (isset($_GET['edit_absensi'])) {
            $id = $_GET['edit_absensi'];
            $edit_result = $conn->query("SELECT * FROM absensi WHERE id=$id");
            $edit_row = $edit_result->fetch_assoc();
        ?>
            <div class="bg-white shadow-lg p-6 rounded-lg border border-gray-200 mt-6">
                <h3 class="text-xl font-semibold mb-4 text-[#3B3B58]">Edit Absensi</h3>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
                    <select name="status" required class="border p-2 rounded mb-2 w-full">
                    <option value="Hadir" <?= isset($edit_row['status']) && $edit_row['status'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
<option value="Sakit" <?= isset($edit_row['status']) && $edit_row['status'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
<option value="Terlambat" <?= isset($edit_row['status']) && $edit_row['status'] == 'Terlambat' ? 'selected' : '' ?>>Terlambat</option>
<option value="Alpha" <?= isset($edit_row['status']) && $edit_row['status'] == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
<option value="Izin" <?= isset($edit_row['status']) && $edit_row['status'] == 'Izin' ? 'selected' : '' ?>>Izin</option>

                    </select>
                    <button type="submit" name="update_absensi" class="bg-[#3B3B58] text-white p-2 rounded">Update Absensi</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>