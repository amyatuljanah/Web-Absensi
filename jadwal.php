<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 800px;
            margin: auto;
        }
        h1 {
            margin-bottom: 20px;
        }
        .categories {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .category {
            padding: 15px;
            border-radius: 8px;
            flex: 1;
            margin: 0 5px;
            cursor: pointer;
            transition: transform 0.3s, background 0.3s;
        }
        .category:hover {
            transform: translateY(-5px);
        }
        .details {
            display: none;
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <nav class="bg-[#3B3B58] text-white w-64 min-h-screen p-6 shadow-xl flex flex-col">
        <h1 class="text-lg font-bold mb-6 flex items-center"><i class="fas fa-user-check mr-2"></i> Absensi Siswa</h1>
        <ul class="space-y-4 flex-grow">
            <li><a href="dashboardsiswa.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
            <li><a href="profile.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-user mr-2"></i>Profil</a></li>
            <li><a href="jadwal.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-calendar-alt mr-2"></i>Jadwal</a></li>
            <a href="loginsiswa.php" class="block hover:text-gray-300 flex items-center mt-auto"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </ul>
    </nav>
    
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Jadwal</h1>
        <div class="categories flex flex-wrap gap-4">
            <a href="perpus.php" class="category bg-blue-500 text-white p-6 rounded-lg shadow-md flex-1">
                <h2 class="text-xl font-semibold">Perpustakaan</h2>
                <p class="mt-2">Absen jaga di perpustakaan</p>
            </a>

            <div class="category bg-green-500 text-white p-6 rounded-lg shadow-md flex-1">
                <a href="kelas.php" class="block text-white">
                    <h2 class="text-xl font-semibold leading-tight pt-2">Kelas</h2>
                    <p class="mt-1">Absen piket di kelas</p>
                </a>
            </div>

            <div class="category bg-red-500 text-white p-6 rounded-lg shadow-md flex-1">
                <a href="kantin.php" class="block text-white">
                    <h2 class="text-xl font-semibold">Kantin</h2>
                    <p class="mt-2">Absen jaga di kantin</p>
                </a>
            </div>
        </div>
    </div>

    <script>
        function showDetails(category) {
            // Hide all details
            document.querySelectorAll('.details').forEach(function(detail) {
                detail.style.display = 'none';
            });
            // Show the selected category details
            document.getElementById(category).style.display = 'block';
        }
    </script>
</body>
</html>