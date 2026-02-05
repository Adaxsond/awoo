<?php
require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Buku;

$bukuWithImage = Buku::whereNotNull('gambar')->first();

if($bukuWithImage) {
    echo "Nama file gambar: " . $bukuWithImage->gambar . "\n";
    echo "URL akses gambar: " . asset('storage/' . $bukuWithImage->gambar) . "\n";
} else {
    echo "Tidak ada entri buku dengan gambar\n";
}
?>