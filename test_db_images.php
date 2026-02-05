<?php

use Illuminate\Support\Facades\DB;

// Check if there are books with images in the database
$bukuWithImages = DB::table('bukus')->whereNotNull('gambar')->first();

if($bukuWithImages) {
    echo "Found book with image:<br>";
    echo "ID: {$bukuWithImages->id}<br>";
    echo "Title: {$bukuWithImages->judul}<br>";
    echo "Image: {$bukuWithImages->gambar}<br>";
    echo "Expected public URL: <a href='/storage/{$bukuWithImages->gambar}' target='_blank'>View Image</a><br>";
} else {
    echo "No books found with images.<br>";
}

// Also get count of total books
$totalBuku = DB::table('bukus')->count();
echo "Total books in database: {$totalBuku}<br>";

// Count books with images
$bukuWithImagesCount = DB::table('bukus')->whereNotNull('gambar')->count();
echo "Books with images: {$bukuWithImagesCount}<br>";

// Check if the file actually exists in storage
if($bukuWithImages && $bukuWithImages->gambar) {
    $fullPath = storage_path('app/public/' . $bukuWithImages->gambar);
    echo "File exists check: " . (file_exists($fullPath) ? 'Yes' : 'No') . "<br>";
    echo "Full path: {$fullPath}<br>";
}