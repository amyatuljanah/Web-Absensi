<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Kelas XI RPL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .box {
            padding: 15px 20px;
            margin: 10px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            position: relative;
            text-align: center;
        }
        .wali { background-color: #4a90e2; }
        .ketua { background-color: #f5a623; }
        .sekretaris, .bendahara { background-color: #a269c9; }
        .seksi { background-color: #4caf50; }
        .lomba { background-color: #d9534f; }
        .row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            position: relative;
        }
        .line {
            width: 2px;
            background-color: black;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        .horizontal-line {
            height: 2px;
            background-color: black;
            position: absolute;
            width: 100%;
            top: 50%;
            left: 0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
    <nav class="bg-[#3B3B58] text-white w-64 h-screen p-6 shadow-xl flex flex-col">
    <h1 class="text-lg font-bold mb-6 flex items-center">
        <i class="fas fa-user-check mr-2"></i> Absensi Siswa
    </h1>
    <ul class="space-y-4 flex-grow">
        <li><a href="dashboardsiswa.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
        <li><a href="profile.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-user mr-2"></i>Profil</a></li>
        <li><a href="jadwal.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-calendar-alt mr-2"></i>Jadwal</a></li>
        <li><a href="kelas1.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-chalkboard mr-2"></i>Kelas</a></li>
        <a href="loginsiswa.php" class="block hover:text-gray-300 flex items-center mt-auto">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
    </a>
    </ul>
</nav>


        <div class="flex-1 p-6">
            <div class="container">
                <div class="box wali">Wali Kelas: Ibu Nuraini Azizah
                    <div class="line" style="height: 20px;"></div>
                </div>
                
                <div class="row">
                    <div class="box ketua">Ketua Kelas: Mohammad Faqih Fathony
                        <div class="line" style="height: 20px;"></div>
                    </div>
                    <div class="box ketua">Wakil Ketua: Naufal Raka Putri Uri
                        <div class="line" style="height: 20px;"></div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="box sekretaris">Sekretaris: Chaylarossa Suryana Putri</div>
                    <div class="box bendahara">Bendahara 1: Davina Maharani</div>
                    <div class="box bendahara">Bendahara 2: Thasya Felisha Despat</div>
                </div>
                
                <div class="row">
                    <div class="box seksi">Seksi Kebersihan: Farrel Ahmad Fabian Chaniago</div>
                    <div class="box seksi">Seksi Keamanan: Rafa Valian Putra Annafi</div>
                    <div class="box seksi">Seksi Kesehatan: Rakan</div>
                    <div class="box seksi">Seksi Kedisiplinan: Rachmat Firmansyah</div>
                    <div class="box lomba">Seksi Lomba: Amyatul Janah</div>
                    <div class="box lomba">Seksi Lomba: Auriza Irhamnas</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>