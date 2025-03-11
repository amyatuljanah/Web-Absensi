<?php
session_start();

// Sertakan file konfigurasi database
require_once 'config.php';

// Aktifkan error reporting (PASTIKAN INI AKTIF)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fungsi untuk membersihkan dan memvalidasi input
function validate_input($data) {
    // Nonaktifkan validasi input untuk sementara waktu
    echo "<p>Validasi input dinonaktifkan untuk debugging.</p>"; // Debugging
    return $data;
}

// Fungsi untuk melakukan login
function login_siswa($conn, $nis, $password) {
    echo "<p>Fungsi login_siswa dipanggil.</p>"; // Debugging
    var_dump($nis, $password); // Debugging

    try {
        // Validasi input
        $nis = validate_input($nis);
        $password = validate_input($password);

        // Periksa apakah NIS dan password kosong
        if (empty($nis) || empty($password)) {
            echo "<p>NIS atau password kosong.</p>"; // Debugging
            return "NIS dan password harus diisi.";
        }

        // Gunakan prepared statement untuk mencegah SQL injection
        $query = "SELECT id, nis, password FROM siswa WHERE nis = ?";
        echo "<p>Query: " . $query . "</p>"; // Debugging
        $stmt = $conn->prepare($query);

        // Periksa apakah prepared statement berhasil dibuat
        if ($stmt === false) {
            echo "<p>Gagal menyiapkan query: " . $conn->error . "</p>"; // Debugging
            throw new Exception("Gagal menyiapkan query: " . $conn->error);
        }

        // Bind parameter
        $stmt->bind_param("s", $nis);
        echo "<p>Parameter di-bind: " . $nis . "</p>"; // Debugging

        // Eksekusi query
        if (!$stmt->execute()) {
            echo "<p>Gagal menjalankan query: " . $stmt->error . "</p>"; // Debugging
            throw new Exception("Gagal menjalankan query: " . $stmt->error);
        }

        // Ambil hasil query
        $result = $stmt->get_result();
        echo "<p>Hasil query:</p>"; // Debugging
        var_dump($result); // Debugging

        // Periksa apakah NIS ditemukan
        if ($result->num_rows > 0) {
            $siswa = $result->fetch_assoc();
            echo "<p>Data siswa:</p>"; // Debugging
            var_dump($siswa); // Debugging

            // Verifikasi password (TANPA HASH - SANGAT TIDAK DISARANKAN UNTUK PRODUKSI)
            if ($password == $siswa['password']) {
                echo "<p>Password cocok!</p>"; // Debugging
                // Set session variables
                $_SESSION['siswa_id'] = $siswa['id'];
                $_SESSION['siswa_nis'] = $nis;
                echo "<p>Sesi diatur: siswa_id = " . $_SESSION['siswa_id'] . ", siswa_nis = " . $_SESSION['siswa_nis'] . "</p>"; // Debugging

                // Berhasil login
                return true;
            } else {
                echo "<p>Password tidak cocok.</p>"; // Debugging
                return "Password salah.";
            }
        } else {
            echo "<p>NIS tidak ditemukan.</p>"; // Debugging
            return "NIS tidak ditemukan.";
        }

        // Tutup statement
      
    } catch (Exception $e) {
        // Tangkap error
        echo "<p>Terjadi kesalahan: " . $e->getMessage() . "</p>"; // Debugging
        return "Terjadi kesalahan: " . $e->getMessage();
    }
}

// Proses login jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<p>Form disubmit.</p>"; // Debugging
    // Ambil data dari form
    $nis = $_POST['username'];
    $password = $_POST['password'];
    echo "<p>Data dari form:</p>"; // Debugging
    var_dump($nis, $password); // Debugging

    // Lakukan login
    $login_result = login_siswa($conn, $nis, $password);
    echo "<p>Hasil login: " . $login_result . "</p>"; // Debugging

    // Jika login berhasil, redirect ke halaman dashboard
    if ($login_result === true) {
        echo "<p>Login berhasil, redirecting...</p>"; // Debugging
        header("Location: dashboardsiswa.php");
        exit();
    } else {
        // Jika login gagal, tampilkan pesan error
        $error_message = $login_result;
    }
} else {
   
}

// Tutup koneksi database di luar blok try-catch
if (isset($conn)) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #222; /* Latar belakang sangat gelap */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
        }
        .login-container {
            background-color: rgba(51, 51, 51, 0.9); /* Warna container lebih terang dari background */
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            z-index: 1;
            color: #eee; /* Teks putih */
        }
        .student-icon {
            font-size: 4rem;
            color: #66B2FF; /* Biru muda */
            margin-bottom: 1rem;
        }
        .form-label {
            text-align: left;
            display: block;
            margin-bottom: 0.5rem;
            color: #ddd; /* Abu-abu terang */
            font-weight: 500;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
            border: none; /* Hilangkan border */
            box-shadow: none; /* Hilangkan shadow */
            transition: border-color 0.3s ease;
            background-color: #eee; /* Latar belakang input putih */
            color: #333; /* Teks gelap */
        }
        .form-input:focus {
            outline: none;
            border-color: #66B2FF; /* Biru muda */
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .login-button {
            background-color: #66B2FF; /* Biru muda */
            color: #111; /* Teks gelap */
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .login-button:hover {
            background-color: #4A90E2; /* Biru lebih gelap */
        }
        
        /* Style for stars background */
        #stars {
          position: fixed;
          width: 100%;
          height: 100%;
          top: 0;
          left: 0;
          z-index: -1; /* Behind the content */
          overflow: hidden; /* Prevent overflow */
          background-color:#222; /* Gelap untuk kontras bintang */
        }
        
        .star {
          position:absolute;
          border-radius:50%;
          background-color:#66B2FF; /* Warna biru muda untuk bintang */
          opacity:.8; 
          animation-duration:.5s; 
          animation-timing-function:ease-in-out; 
          animation-iteration-count: infinite; 
          animation-direction: alternate; 
        }

    </style>
</head>
<body>
    <!-- Stars Background -->
    <div id="stars"></div>

    <div class="login-container">
        <!-- Ikon Siswa -->
        <div class="text-center mb-4">
            <i class="bi bi-mortarboard-fill student-icon"></i>
        </div>

        <h2 class="text-2xl font-bold mb-4">Login Siswa</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="username" class="form-label">NIS</label>
                <input type="text" id="username" name="username" placeholder="Masukkan NIS"
                    class="form-input" required>
            </div>
            <div class="mb-6 relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password"
                    class="form-input" required>
                <!-- Ikon mata untuk toggle password -->
                <i id="togglePassword" class="bi bi-eye-fill toggle-password"></i>
            </div>
            <button type="submit" class="login-button">
                Login
            </button>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // Toggle antara tipe password dan text
            const type = password.type === "password" ? "text" : "password";
            password.type = type;

            // Ganti ikon
            this.classList.toggle("bi-eye-fill");
            this.classList.toggle("bi-eye-slash-fill");
        });

        // JavaScript to create stars
        const starsContainer = document.getElementById('stars');
        
        for (let i = 0; i < 100; i++) { // Create 100 stars
          const star = document.createElement('div');
          star.classList.add('star');
          
          // Set random position and size for each star
          const size = Math.random() * (3 - 1) + 1; // Random size between 1 and 3
          star.style.width = `${size}px`;
          star.style.height = `${size}px`;
          
          star.style.top = `${Math.random() * window.innerHeight}px`;
          star.style.left = `${Math.random() * window.innerWidth}px`;
          
          // Add random animation duration and delay
          star.style.animationDuration = `${Math.random() * (2 - 1) + 1}s`;
          
          starsContainer.appendChild(star);
      }
    </script>
</body>
</html>
