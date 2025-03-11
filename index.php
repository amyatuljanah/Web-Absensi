<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa SMKN 40 Jakarta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #222; /* Latar belakang gelap */
            color: #fff; /* Teks putih untuk kontras */
            overflow-x: hidden;
            line-height: 1.6;
            position: relative;
        }
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .container {
            margin-top: 30px;
        }
        .hero {
            background: rgba(255, 255, 255, 0.1); /* Latar belakang semi-transparan untuk hero */
            padding: 80px 30px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Bayangan lebih gelap */
            margin-bottom: 30px;
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 600;
            color: #fff; /* Warna teks putih */
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Efek bayangan pada teks */
        }
        .hero p {
            font-size: 1.2rem;
            color: #eee; /* Warna teks lebih lembut */
            margin-bottom: 30px;
        }
        .btn-custom {
            padding: 14px 30px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
            background-color: #2979FF;
            border: none;
            border-radius: 50px;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Bayangan lebih gelap */
        }
        .btn-custom:hover {
            background-color: #0D47A1;
            transform: translateY(-3px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.4); /* Bayangan lebih gelap */
        }
        .info-section {
            background: rgba(255, 255, 255, 0.1); /* Latar belakang semi-transparan untuk info section */
            color: #eee; /* Warna teks lebih lembut */
            padding: 50px 30px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Bayangan lebih gelap */
            margin-top: 30px;
        }
        .info-section h2 {
            font-size: 2.2rem;
            font-weight: 600;
            color: #2979FF;
            margin-bottom: 20px;
        }
        .info-section p {
            font-size: 1.1rem;
            line-height: 1.7;
        }
        .info-section ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        .info-section ul li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .info-section ul li i {
            margin-right: 10px;
            color: #2979FF;
            font-size: 1.2rem;
        }
        .footer {
            background-color: #2979FF;
            color: #fff;
            text-align: center;
            padding: 25px;
            border-radius: 15px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="container">
        <div class="hero">
            <h1>Selamat Datang di Sistem Absensi</h1>
            <p>SMKN 40 Jakarta</p>
            <div class="mt-4">
                <a href="login.php" class="btn btn-custom mx-2"><i class="fas fa-user-shield mr-2"></i>Login Admin</a>
                <a href="loginsiswa.php" class="btn btn-custom mx-2"><i class="fas fa-user-graduate mr-2"></i>Login Siswa</a>
            </div>
        </div>
        <div class="info-section">
            <h2>Fitur Utama</h2>
            <p>Sistem ini memungkinkan pengelolaan absensi yang efisien dengan fitur-fitur berikut:</p>
            <ul>
                <li><i class="fas fa-check-circle"></i> Pengisian absensi secara real-time</li>
                <li><i class="fas fa-check-circle"></i> Laporan kehadiran yang mudah diakses</li>
                <li><i class="fas fa-check-circle"></i> Notifikasi kehadiran untuk siswa dan admin</li>
                <li><i class="fas fa-check-circle"></i> Rekapan kehadiran untuk siswa</li>
            </ul>
        </div>
        <footer class="footer">
            &copy; <?= date("Y"); ?> SMKN 40 Jakarta - Semua Hak Dilindungi
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', 'particlesjs-config.json', function() {
            console.log('particles.js config loaded');
        });
    </script>
</body>
</html>
