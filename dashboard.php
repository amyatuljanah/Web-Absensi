<?php
require_once 'config.php';

// Get today's date in Y-m-d format
$today = date('Y-m-d');

// Get total students
$sql_total = "SELECT COUNT(*) as total  FROM siswa";
$result_total = $conn->query($sql_total);
$total_siswa = $result_total->fetch_assoc()['total'];

// Get today's attendance counts
$sql_hadir = "SELECT COUNT(*) as count FROM absensi WHERE status='Hadir' AND DATE(tanggal)='$today'";
$result_hadir = $conn->query($sql_hadir);
$hadir = $result_hadir->fetch_assoc()['count'];

$sql_sakit = "SELECT COUNT(*) as count FROM absensi WHERE status='Sakit' AND DATE(tanggal)='$today'";
$result_sakit = $conn->query($sql_sakit);
$sakit = $result_sakit->fetch_assoc()['count'];

$sql_alpha = "SELECT COUNT(*) as count FROM absensi WHERE status='Alpha' AND DATE(tanggal)='$today'";
$result_alpha = $conn->query($sql_alpha);
$alpha = $result_alpha->fetch_assoc()['count'];

$sql_terlambat = "SELECT COUNT(*) as count FROM absensi WHERE status='Terlambat' AND DATE(tanggal)='$today'";
$result_terlambat = $conn->query($sql_terlambat);
$terlambat = $result_terlambat->fetch_assoc()['count'];

$sql_izin = "SELECT COUNT(*) as count FROM absensi WHERE (status='Izin' OR status IS NULL OR status='') AND DATE(tanggal)='$today'";
$result_izin = $conn->query($sql_izin);
$izin = $result_izin->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <nav class="bg-[#3B3B58] text-white w-64 min-h-screen p-6 shadow-xl flex flex-col">
            <h1 class="text-lg font-bold mb-6 flex items-center"><i class="fas fa-user-check mr-2"></i> Absensi Siswa</h1>
            <ul class="space-y-4 flex-grow">
                <li><a href="dashboard.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
                <li><a href="siswa.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-users mr-2"></i> Data Siswa</a></li>
                <li><a href="absensi.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-calendar-check mr-2"></i> Absensi</a></li>
            </ul>
            <a href="logout.php" class="block hover:text-gray-300 flex items-center mt-auto"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </nav>
        
        <!-- Main content -->
        <div class="flex-1 p-6">
            <div class="bg-white shadow-lg p-6 rounded-lg border border-gray-200 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-semibold text-[#3B3B58] flex items-center">
            <span class="mt-[-100px]">
            <i class="fas fa-home mr-2"></i> Selamat datang di absensi SMKN 40 JAKARTA
            </span>
        </h2>
        <p class=" mt-[-10px] text-gray-600">Gunakan menu di samping untuk mengelola data absensi siswa</p>
    </div>
    <img src="smk.png" alt="foto" class="w-[140px]">
</div>

            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Siswa Card -->
                <div class="bg-[#00BFFF] text-white p-6 rounded-lg shadow-md card">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-users mr-2"></i> Total Siswa
                    </h3>
                    <p class="text-3xl mt-2"><?php echo $total_siswa; ?></p>
                </div>

                <!-- Hadir Card -->
                <div class="bg-[#32CD32] text-white p-6 rounded-lg shadow-md card">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-check-circle mr-2"></i> Hadir Hari Ini
                    </h3>
                    <p class="text-3xl mt-2"><?php echo $hadir; ?></p>
                </div>
                
                <!-- Sakit Card -->
                <div class="bg-[#FF69B4] text-white p-6 rounded-lg shadow-md card">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-medkit mr-2"></i> Sakit
                    </h3>
                    <p class="text-3xl mt-2"><?php echo $sakit; ?></p>
                </div>
                
                <!-- Izin Card -->
                <div class="bg-[#FF8C00] text-white p-6 rounded-lg shadow-md card">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-clipboard-list mr-2"></i> Izin
                    </h3>
                    <p class="text-3xl mt-2"><?php echo $izin; ?></p>
                </div>
                
                                <!-- Alpha Card -->
                <div class="bg-[#FF4500] text-white p-6 rounded-lg shadow-md card">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-times-circle mr-2"></i> Alpha
                    </h3>
                    <p class="text-3xl mt-2"><?php echo $alpha; ?></p>
                </div>

                <!-- Terlambat Card -->
                <div class="bg-[#FFD700] text-white p-6 rounded-lg shadow-md card">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-clock mr-2"></i> Terlambat
                    </h3>
                    <p class="text-3xl mt-2"><?php echo $terlambat; ?></p>
                </div>
            </div>

           <!-- Filter section -->
           <div class="mt-6 bg-white shadow-lg p-6 rounded-lg border border-gray-200">
            <h2 class="text-xl font-semibold mb-4 text-[#3B3B58]">Filter Data Absensi</h2>
            <form action="absensi.php" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="nama" placeholder="Cari nama siswa" class="p-2 border border-gray-300 rounded">
                <input type="date" name="tanggal" class="p-2 border border-gray-300 rounded">
                <select name="status" class="p-2 border border-gray-300 rounded">
                    <option value="">Semua</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Terlambat">Terlambat</option>
                    <option value="Izin">Izin</option>
                    <option value="Alpha">Alpha</option>
                </select>

                <select name="kelas" class="p-2 border border-gray-300 rounded">
                    <option value="">Semua Kelas</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
                
                <button type="submit" class="bg-[#3B3B58] text-white px-4 py-2 rounded hover:bg-[#2A2A45]">Filter</button>
            </form>
        </div>

        </div>
    </div>
</body>
</html>