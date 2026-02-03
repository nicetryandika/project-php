<?php
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan');history.back();</script>";
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query($connection, "SELECT * FROM starlink_controller WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan');history.back();</script>";
    exit;
}
?>

<div class="bg-white rounded-lg shadow-sm">

    <!-- HEADER -->
    <div class="flex items-center justify-between border-b px-6 py-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Detail Controller</h2>
            <p class="text-sm text-gray-500">Informasi lengkap controller</p>
        </div>
    </div>

    <!-- BODY -->
    <div class="p-6">
        <table class="w-full text-sm border-collapse">

            <tr class="border-b">
                <td class="w-1/4 py-3 text-gray-500 font-medium">Nama Controller</td>
                <td class="py-3 text-gray-800 font-semibold">
                    <?= htmlspecialchars($data['nama_controller']); ?>
                </td>
            </tr>

            <tr class="border-b">
                <td class="py-3 text-gray-500 font-medium">IP Public</td>
                <td class="py-3 text-gray-800">
                    <?= htmlspecialchars($data['ip_public']); ?>
                </td>
            </tr>

            <tr class="border-b">
                <td class="py-3 text-gray-500 font-medium">Lokasi</td>
                <td class="py-3 text-gray-800">
                    <?= htmlspecialchars($data['lokasi']); ?>
                </td>
            </tr>

            <tr class="border-b">
                <td class="py-3 text-gray-500 font-medium">Status</td>
                <td class="py-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                        <?= $data['status'] === 'UP'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700'; ?>">
                        <?= htmlspecialchars($data['status']); ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td class="py-3 align-top text-gray-500 font-medium">Keterangan</td>
                <td class="py-3 text-gray-800 leading-relaxed">
                    <?= nl2br(htmlspecialchars($data['keterangan'])); ?>
                </td>
            </tr>

        </table>
        <a href="index.php?page=controller"
           class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
            ← Kembali
        </a>
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end gap-2 border-t px-6 py-4">
        <a href="index.php?page=controller/edit&id=<?= $data['id']; ?>"
           class="px-4 py-2 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">
            Edit
        </a>

        <a href="index.php?page=controller"
           class="px-4 py-2 text-sm bg-gray-400 text-white rounded hover:bg-gray-500">
            Kembali
        </a>
    </div>

</div>
