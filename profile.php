<?php
session_start();
include 'config.php';

// Pastikan siswa sudah login
if (!isset($_SESSION['siswa_id'])) {
    header("Location: loginsiswa.php");
    exit();
}

// Ambil data siswa dari session
$siswa_id = $_SESSION['siswa_id'];

// Ambil data siswa dari database
$query = "SELECT * FROM siswa WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $siswa_id);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();

if (!$siswa) {
    echo "Data siswa tidak ditemukan.";
    exit();
}

// Proses update profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update data siswa
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];

    // Validasi email sebelum digunakan
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Format email tidak valid.";
            $email = ""; // Set email menjadi kosong jika tidak valid
        }
    } else {
        $email = "";
    }

    $query_update = "UPDATE siswa SET nama = ?, kelas = ?, jurusan = ?, email = ? WHERE id = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("ssssi", $nama, $kelas, $jurusan, $email, $siswa_id);
    $stmt_update->execute();

    // Proses upload foto profil
    if (isset($_FILES["foto_profil"]) && $_FILES["foto_profil"]["error"] == 0) {
        $target_dir = "uploads/"; // Direktori penyimpanan foto profil
        $target_file = $target_dir . uniqid() . "_" . basename($_FILES["foto_profil"]["name"]); // Nama file unik
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi file
        $check = getimagesize($_FILES["foto_profil"]["tmp_name"]);
        if ($check === false) {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        // Batasi ukuran file
        if ($_FILES["foto_profil"]["size"] > 500000) {
            echo "Maaf, ukuran file terlalu besar.";
            $uploadOk = 0;
        }

        // Izinkan hanya format gambar tertentu
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
            $uploadOk = 0;
        }

        // Upload file jika semua validasi lolos
        if ($uploadOk == 0) {
            echo "Maaf, file tidak berhasil diupload.";
        } else {
            if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $target_file)) {
                // Update nama file foto profil di database
                $foto_profil = htmlspecialchars(basename($target_file)); // Simpan nama file yang unik
                $query_update_foto = "UPDATE siswa SET foto = ? WHERE id = ?";
                $stmt_update_foto = $conn->prepare($query_update_foto);
                $stmt_update_foto->bind_param("si", $foto_profil, $siswa_id);
                $stmt_update_foto->execute();

                echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='profile.php';</script>";
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file.";
            }
        }
    } else {
        // Tidak ada file baru diupload, tetap tampilkan pesan berhasil
        echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='profile.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <nav class="bg-[#3B3B58] text-white w-64 min-h-screen p-6 shadow-xl flex flex-col">
            <h1 class="text-lg font-bold mb-6 flex items-center"><i class="fas fa-user-check mr-2"></i> Absensi Siswa</h1>
            <ul class="space-y-4 flex-grow">
            <li><a href="dashboardsiswa.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
            <li><a href="profile.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-user mr-2"></i>Profil</a></li>
            <li><a href="jadwal.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-calendar-alt mr-2"></i>Jadwal</a></li>
            <li><a href="kelas1.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-chalkboard mr-2"></i>Kelas</a></li>
            <a href="loginsiswa.php" class="block hover:text-gray-300 flex items-center mt-auto"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </ul>
        </nav>

        <!-- Main content -->
        <div class="flex-1 p-6">
            <h2 class="text-2xl font-semibold mb-6 text-[#3B3B58]"><i class="fas fa-user mr-2"></i>Profil Siswa</h2>

            <div class="bg-white shadow-lg p-6 rounded-lg border border-gray-200">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="flex items-center mb-4">
                        <?php if (!empty($siswa['foto'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($siswa['foto']); ?>" alt="Foto Profil" class="profile-img mr-4">
                        <?php else: ?>
                            <img src="uploads/default.jpg" alt="Foto Profil" class="profile-img mr-4">
                        <?php endif; ?>
                        <div>
                            <label for="foto_profil" class="block text-gray-700 text-sm font-bold mb-2">Update Foto Profil:</label>
                            <input type="file" name="foto_profil" id="foto_profil" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                        <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($siswa['nama'] ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="kelas" class="block text-gray-700 text-sm font-bold mb-2">Kelas:</label>
                        <input type="text" name="kelas" id="kelas" value="<?php echo htmlspecialchars($siswa['kelas'] ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="jurusan" class="block text-gray-700 text-sm font-bold mb-2">Jurusan:</label>
                        <input type="text" name="jurusan" id="jurusan" value="<?php echo htmlspecialchars($siswa['jurusan'] ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($siswa['email'] ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <button type="submit" class="bg-[#3B3B58] hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Profil</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>