<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas XI RPL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
                <a href="loginsiswa.php" class="block hover:text-gray-300 flex items-center mt-auto"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
            </ul>
        </nav>

        <div class="flex-1 p-6">
            <h1 class="text-3xl font-bold mb-6">Kelas XI RPL</h1>

            <!-- Kategori Daftar Siswa -->
            <div class="w-3/4 bg-white p-6 rounded-lg shadow-lg mb-6 text-center">
                <h2 class="text-2xl font-bold mb-4">Daftar Siswa Kelas XI RPL</h2>
                <p class="mb-4">Lihat daftar lengkap siswa di kelas XI RPL.</p>
                <button onclick="window.location.href='namasiswarpl.php';"
                    class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">
                    Lihat Daftar Siswa
                </button>
            </div>

            <!-- Kategori Struktur Kelas -->
            <div class="w-3/4 bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-2xl font-bold mb-4">Struktur Kelas</h2>
                <p class="mb-4">Lihat struktur organisasi kelas XI RPL.</p>
                <button onclick="window.location.href='strukturkelas.php?struktur';"
                    class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition">
                    Lihat Struktur Kelas
                </button>
            </div>
        </div>
    </div>
</body>
</html>