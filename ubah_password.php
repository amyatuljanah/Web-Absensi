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

// Proses ubah password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Validasi
    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi_password)) {
        $error = "Semua field harus diisi.";
    } elseif ($password_baru != $konfirmasi_password) {
        $error = "Password baru dan konfirmasi password tidak cocok.";
    } else {
        // Ambil password lama dari database
        $query = "SELECT password FROM siswa WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $siswa_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $siswa = $result->fetch_assoc();

        // Verifikasi password lama
        if (password_verify($password_lama, $siswa['password'])) {
            // Hash password baru
            $password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);

            // Update password di database
            $query_update = "UPDATE siswa SET password = ? WHERE id = ?";
            $stmt_update = $conn->prepare($query_update);
            $stmt_update->bind_param("si", $password_baru_hash, $siswa_id);
            if ($stmt_update->execute()) {
                echo "<script>
                        alert('Password berhasil diubah!');
                        window.location.href='profile.php';
                      </script>";
            } else {
                $error = "Terjadi kesalahan saat mengubah password.";
            }
        } else {
            $error = "Password lama tidak sesuai.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <nav class="bg-[#3B3B58] text-white w-64 min-h-screen p-6 shadow-xl flex flex-col">
            <h1 class="text-lg font-bold mb-6 flex items-center"><i class="fas fa-user-check mr-2"></i> Absensi Siswa</h1>
            <ul class="space-y-4 flex-grow">
                <li><a href="dashboardsiswa.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
                <li><a href="profile.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-user mr-2"></i>Profil</a></li>
            </ul>
            <a href="logout.php" class="block hover:text-gray-300 flex items-center mt-auto"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </nav>

        <!-- Main content -->
        <div class="flex-1 p-6">
            <h2 class="text-2xl font-semibold mb-6 text-[#3B3B58]"><i class="fas fa-key mr-2"></i>Ubah Password</h2>

            <div class="bg-white shadow-lg p-6 rounded-lg border border-gray-200">
                <?php if (isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline"><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-4 relative">
                        <label for="password_lama" class="block text-gray-700 text-sm font-bold mb-2">Password Lama:</label>
                        <input type="password" name="password_lama" id="password_lama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <i id="togglePasswordLama" class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500" style="bottom: 5px;"></i>
                    </div>
                    <div class="mb-4 relative">
                        <label for="password_baru" class="block text-gray-700 text-sm font-bold mb-2">Password Baru:</label>
                        <input type="password" name="password_baru" id="password_baru" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <i id="togglePasswordBaru" class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500" style="bottom: 5px;"></i>
                    </div>
                    <div class="mb-4 relative">
                        <label for="konfirmasi_password" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password:</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <i id="toggleKonfirmasiPassword" class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500" style="bottom: 5px;"></i>
                    </div>
                    <button type="submit" class="bg-[#3B3B58] hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"><i class="fas fa-save mr-2"></i>Ubah Password</button>
                    <a href="profile.php" class="inline-block ml-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"><i class="fas fa-times mr-2"></i>Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        const togglePasswordLama = document.querySelector("#togglePasswordLama");
        const passwordLama = document.querySelector("#password_lama");

        togglePasswordLama.addEventListener("click", function () {
            const type = passwordLama.type === "password" ? "text" : "password";
            passwordLama.type = type;
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });

        const togglePasswordBaru = document.querySelector("#togglePasswordBaru");
        const passwordBaru = document.querySelector("#password_baru");

        togglePasswordBaru.addEventListener("click", function () {
            const type = passwordBaru.type === "password" ? "text" : "password";
            passwordBaru.type = type;
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });

        const toggleKonfirmasiPassword = document.querySelector("#toggleKonfirmasiPassword");
        const konfirmasiPassword = document.querySelector("#konfirmasi_password");

        toggleKonfirmasiPassword.addEventListener("click", function () {
            const type = konfirmasiPassword.type === "password" ? "text" : "password";
            konfirmasiPassword.type = type;
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>