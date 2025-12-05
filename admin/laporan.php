<?php 
include '../config/koneksi.php';
include 'header.php'; // Header sudah memuat CSS Tailwind & Sidebar

$semua_data = [];
// Default tanggal: Awal bulan ini sampai Hari ini
$tgl_mulai = date('Y-m-01');
$tgl_selesai = date('Y-m-d');

if (isset($_POST['kirim'])) {
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
}

// Query Data
$ambil = $conn->query("SELECT * FROM orders JOIN users ON orders.id_user=users.id_user 
    WHERE status_order='selesai' AND date(tanggal_order) BETWEEN '$tgl_mulai' AND '$tgl_selesai' ORDER BY id_order DESC");

while ($pecah = $ambil->fetch_assoc()) {
    $semua_data[] = $pecah;
}
?>

<!-- HEADER HALAMAN -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">📄 Laporan Penjualan</h1>
        <p class="text-gray-500 text-sm">Rekap data transaksi yang sudah selesai.</p>
    </div>
</div>

<!-- FORM FILTER (Akan hilang saat di-print sesuai CSS di header.php) -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
    <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Dari Tanggal</label>
            <input type="date" name="tgl_mulai" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" value="<?php echo $tgl_mulai ?>">
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Sampai Tanggal</label>
            <input type="date" name="tgl_selesai" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" value="<?php echo $tgl_selesai ?>">
        </div>
        
        <div>
            <button name="kirim" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition shadow-md flex justify-center items-center gap-2">
                <i class="fa-solid fa-filter"></i> Tampilkan Laporan
            </button>
        </div>

    </form>
</div>

<!-- TABEL LAPORAN -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Judul Laporan di Tabel (Hanya muncul saat Print biasanya, tapi kita tampilkan saja) -->
    <div class="p-6 border-b border-gray-100 text-center">
        <h3 class="text-lg font-bold text-gray-800 uppercase">Laporan Penjualan FrostBite</h3>
        <p class="text-sm text-gray-500">Periode: <?php echo date("d F Y", strtotime($tgl_mulai)); ?> s/d <?php echo date("d F Y", strtotime($tgl_selesai)); ?></p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                <?php 
                $total = 0; 
                $no = 1;
                
                if (empty($semua_data)) {
                    echo '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data penjualan pada periode ini.</td></tr>';
                }

                foreach ($semua_data as $key => $value): 
                    $total += $value['total_bayar']; 
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?php echo $no++; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800"><?php echo $value['nama_lengkap']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                        <?php echo date("d M Y", strtotime($value['tanggal_order'])); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-800">
                        Rp <?php echo number_format($value['total_bayar']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">
                            <?php echo $value['status_order']; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot class="bg-gray-100">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-700 uppercase text-sm">Total Pemasukan</td>
                    <td class="px-6 py-4 text-right font-bold text-blue-600 text-lg">Rp <?php echo number_format($total); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- TOMBOL PRINT -->
<?php if (!empty($semua_data)): ?>
    <div class="mt-8 flex justify-end">
        <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-green-200 transition transform hover:-translate-y-1 flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
    </div>
<?php endif; ?>

<!-- Menutup tag main yang dibuka di header.php -->
    </main>
</div> 

</body>
</html>