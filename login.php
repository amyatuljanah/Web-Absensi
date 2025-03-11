<?php
session_start();
include 'config.php'; // Pastikan config.php berisi koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Gunakan prepared statement untuk mencegah SQL Injection
    $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login berhasil
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Login gagal. Periksa kembali username dan password.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
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
            background-color: #333; /* Warna container lebih terang dari background */
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
        .admin-icon {
            font-size: 4rem;
            color: #66B2FF; /* Biru cerah */
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
            border: none;
            box-shadow: none;
            transition: border-color 0.3s ease;
            background-color: #eee; /* Latar belakang input putih */
            color: #333; /* Teks gelap */
        }
        .form-input:focus {
            outline: none;
            border-color: #66B2FF; /* Biru cerah */
            box-shadow: 0 0 0.25rem rgba(102, 178, 255, 0.3);
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888; /* Abu-abu sedang */
        }
        .login-button {
            background-color: #66B2FF; /* Biru cerah */
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
        .relative {
            position: relative;
        }

        /* Style for particles */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }
    </style>
</head>
<body>
    <!-- Particles Background -->
    <div id="particles-js"></div>

    <div class="login-container">
        <!-- Ikon Admin -->
        <div class="text-center mb-4">
            <i class="bi bi-person-circle admin-icon"></i>
        </div>

        <h2 class="text-2xl font-bold mb-4">Login Admin</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username"
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
    </script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#66B2FF' /* Biru cerah */
                },
                shape: {
                    type: 'circle',
                },
                opacity: {
                    value: 0.5,
                    random: true,
                },
                size: {
                    value: 5,
                    random: true,
                },
                move: {
                    enable: true,
                    speed: 3,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: false,
                        mode: 'repulse'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    },
                    resize: true
                },
                modes: {
                    push: {
                        particles_nb: 4
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.4
                    }
                }
            },
            retina_detect: true
        });
    </script>
</body>
</html>
