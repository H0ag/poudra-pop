<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Products extends Seeder
{
    private function encodeImage(string $path): ?string
    {
        if (!file_exists($path)) {
            return null;
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        
        return 'data:image/'.$type.';base64,'.base64_encode($data);
    }
    public function run()
    {
        $imgDir = WRITEPATH . 'seeds/images/';
        
        $productsTable = $this->db->table('products');

        // First, ensure at least one category exists to avoid FK errors
        $categoryTable = $this->db->table('categories');
        $category = $categoryTable->where('slug', 'general')->get()->getRow();
        
        if (!$category) {
            $categoryTable->insert([
                'name' => 'General Factory',
                'slug' => 'general'
            ]);
            $categoryId = $this->db->insertID();
        } else {
            $categoryId = $category->id;
        }

        $data = [
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-SOURS-001',
                'name'                   => 'S-OURS',
                'price'                  => 12.99,
                'stock_status'           => 'En stock (Tension stable)',
                'composition'            => 'Gélatine de pixel compressée à 400 bars, extraits d\'éclairs de tempête et 2% de néon liquide.',
                'flavor'                 => 'Acide',
                'effect'                 => 'Contraction faciale symétrique et capacité de voir les ondes Wi-Fi pendant 12 secondes.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'Sours.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'Sours-real.webp'),
                'is_best_seller'         => true,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-HERO-001',
                'name'                   => 'EL SUPER HEROÏNE',
                'price'                  => 122.99,
                'stock_status'           => 'Usine en folie !',
                'composition'            => 'Polymères de bravoure synthétique, 0.5% d\'héroïsme pur (poids net) et colorant vert interdit dans 12 pays.',
                'flavor'                 => '??? Argh.',
                'effect'                 => 'Lévitation stabilisée à exactement 85cm du sol. Note : ne protège pas contre les murs.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'el-super-heroine.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'el-super-heroine-real.webp'),
                'is_best_seller'         => true,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-COCO-001',
                'name'                   => 'COCO CALINE',
                'price'                  => 17.90,
                'stock_status'           => 'Disponible (Quantité limitée)',
                'composition'            => 'Micro-particules de duvet de panda, sucre de canne astral et arômes de sieste prolongée.',
                'flavor'                 => 'doré',
                'effect'                 => 'Compulsion irrésistible à prendre le mobilier en photo ou à serrer des inconnus dans ses bras.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'coco-caline.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'coco-caline-real.webp'),
                'is_best_seller'         => true,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-KIT-001',
                'name'                   => 'KIT - Sucre bonbons',
                'price'                  => 44.44,
                'stock_status'           => 'Édition limitée (Balayage matinal)',
                'composition'            => 'Résidus de production collectés avec amour sous les machines et cristaux de quartz comestibles.',
                'flavor'                 => '... bof',
                'effect'                 => 'Sentiment diffus de satisfaction numérique et apparition de bugs mineurs dans la vision périphérique.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'box-sucre-bonbons.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'box-sucre-bonbons-real.webp'),
                'is_best_seller'         => true,
            ],
        ];

        $productsTable->insertBatch($data);
    }
}
