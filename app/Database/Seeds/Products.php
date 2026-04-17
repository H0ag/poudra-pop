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
                'is_best_seller'         => false,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-PERLIM-001',
                'name'                   => 'POUDRA DE PERLIMPINPIN',
                'price'                  => 49.30,
                'stock_status'           => 'En marche',
                'composition'            => '0% de promesses, 100% de charisme en poudre, extraits de discours de 3 heures.',
                'flavor'                 => 'Présidentiel',
                'effect'                 => 'Capacité de débattre pendant toute une nuit sans jamais répondre à une seule question.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'poudra-perlimpinpin.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'poudra-perlimpinpin-real.webp'),
                'is_best_seller'         => false,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-DURA-001',
                'name'                   => 'DURA-LEAN',
                'price'                  => 22.00,
                'stock_status'           => 'Survolté',
                'composition'            => 'Lithium comestible, gélatine rose fluo et extraits de foudre de catégorie 4.',
                'flavor'                 => 'Électrique',
                'effect'                 => 'Hyperactivité motrice : vous pouvez repeindre votre salon en 4 minutes, mais avec les dents.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'dura-ligne.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'dura-ligne-real.webp'),
                'is_best_seller'         => false,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-NESQUE-001',
                'name'                   => 'NESQUE-QUICK',
                'price'                  => 19.99,
                'stock_status'           => 'Instantané',
                'composition'            => 'Cacao décoloré en laboratoire, sucre de synthèse et molécules de vitesse pure.',
                'flavor'                 => 'Cacao-Blanc',
                'effect'                 => 'Suppression définitive du concept de sommeil. Votre cerveau tourne à 14 000 tours/minute.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'nesque-quick.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'nesque-quick-real.webp'),
                'is_best_seller'         => false,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-RAID-001',
                'name'                   => 'RAID-BOULE',
                'price'                  => 15.00,
                'stock_status'           => 'En plein vol',
                'composition'            => 'Gaz carbonique pressurisé, nectar de taureau énervé et extraits d\'altitude.',
                'flavor'                 => 'Taurine',
                'effect'                 => 'Pousse d\'ailes immédiate. Note : le parachute et le train d\'atterrissage ne sont pas inclus.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'raid-boule.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'raid-boule-real.webp'),
                'is_best_seller'         => true,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-PUR-001',
                'name'                   => 'MONSIEUR PUR',
                'price'                  => 25.50,
                'stock_status'           => 'Étincelant',
                'composition'            => 'Cristaux de javel sucrée, menthol industriel et agents blanchissants pour l\'âme.',
                'flavor'                 => 'Frais',
                'effect'                 => 'Nettoyage complet des pensées parasites. Votre esprit devient aussi lisse et propre que sa tête.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'monsieur-pur.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'monsieur-pur-real.webp'),
                'is_best_seller'         => false,
            ],
            [
                'category_id'            => $categoryId,
                'reference'              => 'SP-VACHE-001',
                'name'                   => 'LA VACHE QUI BRILLE',
                'price'                  => 16.60,
                'stock_status'           => 'Hilare',
                'composition'            => 'Fromage de synthèse galactique, cristaux de joie pure et 1% de lait de lune.',
                'flavor'                 => 'Lacté',
                'effect'                 => 'Fou rire incontrôlable pendant 45 minutes, même en lisant les conditions générales d\'utilisation.',
                'image_pixel_base64'     => $this->encodeImage($imgDir . 'la-vache-qui-brille.webp'),
                'image_realistic_base64' => $this->encodeImage($imgDir . 'la-vache-qui-brille-real.webp'),
                'is_best_seller'         => false,
            ],
        ];

        $productsTable->insertBatch($data);
    }
}
