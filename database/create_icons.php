<?php

function makeIcon($size, $filename) {
    $img = imagecreatetruecolor($size, $size);
    $bg = imagecolorallocate($img, 15, 23, 42); // #0f172a
    $primary = imagecolorallocate($img, 16, 185, 129); // #10b981
    $white = imagecolorallocate($img, 255, 255, 255);

    imagefill($img, 0, 0, $bg);
    imagefilledellipse($img, $size / 2, $size / 2, $size * 0.8, $size * 0.8, $primary);
    
    // Draw heart/hand icon approximation
    imagefilledrectangle($img, $size * 0.35, $size * 0.35, $size * 0.65, $size * 0.65, $white);
    
    imagepng($img, $filename);
    imagedestroy($img);
}

makeIcon(192, __DIR__ . '/../public/icon-192.png');
makeIcon(512, __DIR__ . '/../public/icon-512.png');
echo "Icons created successfully";
