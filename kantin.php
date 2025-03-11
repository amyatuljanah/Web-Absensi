<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piket Kantin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <nav class="bg-[#3B3B58] text-white w-64 min-h-screen p-6 shadow-xl fixed">
        <h1 class="text-lg font-bold mb-6 flex items-center">
            <i class="fas fa-book mr-2"></i> Piket Kantin
        </h1>
        <ul class="space-y-4">
            <li><a href="dashboardsiswa.php" class="block hover:text-gray-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="ml-72 p-8">
        <h2 class="text-2xl font-bold mb-6">Kategori Kantin</h2>
        <div class="grid grid-cols-3 gap-6">
            <a href="jadwalkantin.php?kategori=Kantin1" class="bg-white p-6 rounded-lg shadow-md text-center hover:bg-gray-200">
                <h3 class="text-lg font-semibold">Kantin 1</h3>
            </a>
            <a href="jadwalkantin.php?kategori=Kantin2" class="bg-white p-6 rounded-lg shadow-md text-center hover:bg-gray-200">
                <h3 class="text-lg font-semibold">Kantin 2</h3>
            </a>
            <a href="jadwalkantin.php?kategori=Kantin3" class="bg-white p-6 rounded-lg shadow-md text-center hover:bg-gray-200">
                <h3 class="text-lg font-semibold">Kantin 3</h3>
            </a>
            <a href="jadwalkantin.php?kategori=Kantin4" class="bg-white p-6 rounded-lg shadow-md text-center hover:bg-gray-200">
                <h3 class="text-lg font-semibold">Kantin 4</h3>
            </a>
            <a href="jadwalkantin.php?kategori=Kantin5" class="bg-white p-6 rounded-lg shadow-md text-center hover:bg-gray-200">
                <h3 class="text-lg font-semibold">Kantin 5</h3>
            </a>
            <a href="jadwalkantin.php?kategori=Kantin6" class="bg-white p-6 rounded-lg shadow-md text-center hover:bg-gray-200">
                <h3 class="text-lg font-semibold">Kantin 6</h3>
            </a>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>