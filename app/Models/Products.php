<?php

namespace App\Models;

use CodeIgniter\Model;

class Products extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_id', 'reference', 'name', 'price', 'stock_status', 'composition', 'flavor', 'effect', 'image_pixel_base64', 'image_realistic_base64', 'is_best_seller'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Resize an image from raw binary data and return it in WebP format.
     *
     * This function resizes an image to the specified width and height.
     * It can optionally crop the image to fit the exact dimensions.
     * Transparency is preserved.
     *
     * @param string $imgData The raw image data (binary string).
     * @param int    $w       The target width.
     * @param int    $h       The target height.
     * @param bool   $crop    Whether to crop the image to the exact dimensions (default: false).
     *
     * @return string|false The resized image in WebP format as a binary string, or false on failure.
     */
    public function resize_image($imgData, $w, $h, $crop = false)
    {
        $info = getimagesizefromstring($imgData);
        if (!$info) return false;

        $width = $info[0];
        $height = $info[1];

        $src = imagecreatefromstring($imgData);
        if (!$src) return false;

        $r = $width / $height;

        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        // Retourne l'image redimensionnée en WebP
        ob_start();
        imagewebp($dst, null, 85);
        $output = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        return $output;
    }
}
