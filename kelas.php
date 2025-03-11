<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Hari</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-start min-h-screen pt-10">

    <h1 class="text-3xl font-bold mb-6">Pilih Hari</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-3/4">
        <?php
        $hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"];
        $colors = ["blue", "yellow", "green", "purple", "red"];
        
        foreach ($hari as $index => $h) {
            $color = $colors[$index];
            echo "
            <a href='jadwal1.php?hari=$h' class='block p-6 bg-$color-500 text-white rounded-xl shadow-lg text-center'>
                <h2 class='text-2xl font-bold'>$h</h2>
                <p class='text-lg'>Lihat siswa yang piket hari $h</p>
            </a>";
        }
        ?>
    </div>

</body>
</html>
