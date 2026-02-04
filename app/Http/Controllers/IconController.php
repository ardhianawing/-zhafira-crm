<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class IconController extends Controller
{
    /**
     * Generate PWA icons dynamically
     */
    public function generate($size)
    {
        $size = (int) $size;

        // Validate size
        $allowedSizes = [72, 96, 128, 144, 152, 192, 384, 512];
        if (!in_array($size, $allowedSizes)) {
            $size = 192;
        }

        // Create image
        $image = imagecreatetruecolor($size, $size);

        // Colors - Zhafira Green and Gold
        $green = imagecolorallocate($image, 15, 61, 46); // #0f3d2e
        $gold = imagecolorallocate($image, 201, 162, 39); // #c9a227
        $white = imagecolorallocate($image, 255, 255, 255);

        // Fill background with green
        imagefill($image, 0, 0, $green);

        // Draw a gold circle/badge in center
        $centerX = $size / 2;
        $centerY = $size / 2;
        $radius = $size * 0.35;

        imagefilledellipse($image, (int)$centerX, (int)$centerY, (int)($radius * 2), (int)($radius * 2), $gold);

        // Draw "Z" letter
        $fontSize = $size * 0.4;
        $font = 5; // Built-in font

        // Simple "Z" using lines
        $padding = $size * 0.25;
        $lineWidth = $size * 0.08;

        // Draw Z shape with rectangles
        // Top horizontal line
        imagefilledrectangle($image,
            (int)($padding),
            (int)($padding),
            (int)($size - $padding),
            (int)($padding + $lineWidth),
            $green);

        // Diagonal line (using multiple rectangles)
        $steps = 20;
        for ($i = 0; $i < $steps; $i++) {
            $x = $size - $padding - ($i * ($size - 2 * $padding) / $steps);
            $y = $padding + ($i * ($size - 2 * $padding - $lineWidth) / $steps);
            imagefilledrectangle($image,
                (int)($x - $lineWidth/2),
                (int)$y,
                (int)($x + $lineWidth/2),
                (int)($y + $lineWidth),
                $green);
        }

        // Bottom horizontal line
        imagefilledrectangle($image,
            (int)($padding),
            (int)($size - $padding - $lineWidth),
            (int)($size - $padding),
            (int)($size - $padding),
            $green);

        // Output
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return response($imageData, 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=31536000');
    }
}
