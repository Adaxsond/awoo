<?php

use Illuminate\Support\Facades\DB;

// Check if there are books with images in the database
$bukuWithImages = DB::table('bukus')->whereNotNull('gambar')->first();

if($bukuWithImages) {
    echo "Found book with image:\n";
    echo "ID: {$bukuWithImages->id}\n";
    echo "Title: {$bukuWithImages->judul}\n";
    echo "Image: {$bukuWithImages->gambar}\n";
    echo "Expected path: storage/{$bukuWithImages->gambar}\n";
} else {
    echo "No books found with images.\n";
}

// Also get count of total books
$totalBuku = DB::table('bukus')->count();
echo "Total books in database: {$totalBuku}\n";

// Count books with images
$bukuWithImagesCount = DB::table('bukus')->whereNotNull('gambar')->count();
echo "Books with images: {$bukuWithImagesCount}\n";

?>