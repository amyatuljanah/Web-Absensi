<?php
require_once 'config.php';

// Fungsi untuk mengambil jumlah status absensi
function getAttendanceCount($conn, $status, $today) {
  $sql = "SELECT COUNT(*) as count FROM absensi WHERE status=? AND DATE(tanggal)=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $status, $today);
  $stmt->execute();
  $result = $stmt->get_result();
  $count = $result->fetch_assoc()['count'];
  $stmt->close();
  return $count;
}

// Get today's date in Y-m-d format
$today = date('Y-m-d');

// Get total students
$sql_total = "SELECT COUNT(*) as total FROM siswa";
$result_total = $conn->query($sql_total);
$total_siswa = $result_total->fetch_assoc()['total'];

// Get today's attendance counts
$hadir = getAttendanceCount($conn, 'Hadir', $today);
$sakit = getAttendanceCount($conn, 'Sakit', $today);
$alpha = getAttendanceCount($conn, 'Alpha', $today);
$terlambat = getAttendanceCount($conn, 'Terlambat', $today);
$izin = getAttendanceCount($conn, 'Izin', $today);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
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
        
        <div class="flex-1 p-6">
            <div class="bg-white shadow-lg p-6 rounded-lg border border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-[#3B3B58] flex items-center">
                        <span class="mt-[-100px]">
                            <i class="fas fa-home mr-2"></i> Selamat datang di absensi SMKN 40 JAKARTA
                        </span>
                    </h2>
                    <p class="mt-[-10px] text-gray-600">Gunakan menu di samping untuk mengelola data absensi siswa</p>
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

            <div class="mt-6 bg-white shadow-lg p-6 rounded-lg border border-gray-200">
                <h3 class="text-xl font-semibold mb-4"><i class="fas fa-table mr-2"></i> Rekap Absensi Bulanan</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rekap_absensi as $status => $jumlah) : ?>
                        <tr>
                            <td class="border p-2 text-center"> <?php echo $status; ?> </td>
                            <td class="border p-2 text-center"> <?php echo $jumlah; ?> </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 bg-white shadow-lg p-6 rounded-lg border border-gray-200">
                <h3 class="text-xl font-semibold mb-4"><i class="fas fa-chart-pie mr-2"></i> Diagram Absensi Bulanan</h3>
                <div class="w-full md:w-1/2 mx-auto">
                    <canvas id="chartAbsensi"></canvas>
                </div>
                <script>
                    var ctx = document.getElementById('chartAbsensi').getContext('2d');
                    var chartAbsensi = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: <?php echo json_encode(array_keys($rekap_absensi)); ?>,
                            datasets: [{
                                data: <?php echo json_encode(array_values($rekap_absensi)); ?>,
                                backgroundColor: ['#4CAF50', '#FFC107', '#FF5722', '#F44336', '#03A9F4']
                            }]
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</body>
</html>