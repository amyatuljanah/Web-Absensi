<?php
$hari = $_GET['hari'] ?? "Tidak diketahui";
$siswa = [
    "Senin" => ["Gielang", "Januar", "Chika","Stefan","Fathir","Mahes","Riski Fais"],
    "Selasa" => ["Rafa", "Melvin", "Kaysan", "Hafiz", "Amy", "Dimas", "Fahry"],
    "Rabu" => ["Faqih", "Royyan", "Yusuf", "Firman", "Davina","Gibran","Bani","Rakha"],
    "Kamis" => ["Barvio", "Rossa", "Auriza","Lutfan","Thasya","Zaky","Naufal"],
    "Jumat" => ["Lingga", "Farrel", "Dedes","Faiz H","Rafi","Syabit","Rakan"]
];

$listSiswa = $siswa[$hari] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Piket - <?= $hari ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-start min-h-screen pt-10">

    <h1 class="text-3xl font-bold mb-6">Jadwal Piket Hari <?= $hari ?></h1>

    <table class="bg-white w-3/4 shadow-lg rounded-xl overflow-hidden">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="py-3 px-6 text-left">No</th>
                <th class="py-3 px-6 text-left">Nama Siswa</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($listSiswa)) {
                echo "<tr><td colspan='3' class='py-4 px-6 text-center'>Tidak ada siswa yang piket hari ini</td></tr>";
            } else {
                foreach ($listSiswa as $index => $nama) {
                    echo "
                    <tr class='border-b'>
                        <td class='py-4 px-6'>" . ($index + 1) . "</td>
                        <td class='py-4 px-6'>$nama</td>
                        <td class='py-4 px-6 text-center'>
                            <button class='bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 mr-2' onclick='markAsPresent(\"$nama\")'>
                                Absen
                            </button>
                            <button class='bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700' onclick='showForm(\"$nama\", \"Tidak Piket\")'>
                                Tidak Piket
                            </button>
                        </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Modal Form Alasan -->
    <div id="formContainer" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-2xl font-bold mb-4">Form Alasan</h2>
            <form id="formAlasan" method="POST" action="admin1.php">
                <input type="hidden" id="namaSiswa" name="namaSiswa">
                <input type="hidden" id="aksi" name="aksi">
                <input type="hidden" name="hari" value="<?= $hari ?>">
                <div class="mb-4">
                    <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan</label>
                    <textarea id="alasan" name="alasan" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2" onclick="hideForm()">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function markAsPresent(nama) {
            window.location.href = 'admin1.php?nama=' + nama + '&status=Hadir&hari=<?= $hari ?>';
        }

        function fillForm(nama, aksi) {
            document.getElementById('namaSiswa').value = nama;
            document.getElementById('aksi').value = aksi;
        }

        function showForm(nama, aksi) {
            fillForm(nama, aksi);
            document.getElementById('formContainer').classList.remove('hidden');
        }

        function hideForm() {
            document.getElementById('formContainer').classList.add('hidden');
        }
    </script>

</body>
</html>