<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index():string
    {
        $bestsellers = $this->productModel->select('id, name, flavor, price, reference')->where('is_best_seller', true)->findAll();
        $data = [
            'best_sellers' => $bestsellers
        ];
        return $this->twig->render("home", $data);
    }

    /**
     * Returns the item's thumbnail as a resized WebP image.
     *
     * This method retrieves a item's thumbnail from the database, optionally resizes it,
     * and outputs it directly as a WebP image. The 'size' query parameter can be used
     * to request a custom dimension, with a maximum limit of 400 pixels. The default
     * size is 150 pixels.
     *
     * @param int $itemID The ID of the item whose thumbnail is requested.
     * @return void Outputs the image directly and terminates the script.
     */
    public function item_thumbnail($itemID, $real)
    {
        $size = min((int) ($this->request->getGet("size") ?? 150), 400);

        if($real == "0") {    
            $thumbnail = $this->productModel->select('image_pixel_base64')->where('id', $itemID)->first()['image_pixel_base64'];
        } else {
            $thumbnail = $this->productModel->select('image_realistic_base64')->where('id', $itemID)->first()['image_realistic_base64'];
        }

        if (str_starts_with($thumbnail, "data:image/")) {
            $thumbnail = explode(",", $thumbnail)[1];
        }

        $imgData = base64_decode($thumbnail);

        $resizedImage = $this->productModel->resize_image($imgData, $size, $size);

        header("Content-Type: image/webp");
        echo $resizedImage;
        exit();
    }

    public function product($itemID):string
    {
        $item = $this->productModel->select('id, name, stock_status, price, reference, effect, flavor, composition')->where('reference', $itemID)->first();
        $data = [
            'item' => $item
        ];
        return $this->twig->render("product", $data);
    }

    public function catalogue():string
    {
        $products = $this->productModel->select('id, name, flavor, price, reference')->findAll();
        $data = [
            'products' => $products
        ];
        return $this->twig->render('catalogue', $data);
    }

    public function cart():string
    {
        return $this->twig->render('cart');
    }

    /**
     * POST /user/getcart
     * Process the localStorage JSON and return validated product data
     */
    public function getCart()
    {
        // 1. Get JSON from request body (true for associative array)
        $cartData = $this->request->getJSON(true);

        if (empty($cartData) || !is_array($cartData)) {
            return $this->response->setJSON([
                'success'     => true,
                'items'       => [],
                'grand_total' => 0.00
            ]);
        }

        $processedItems = [];
        $grandTotal     = 0.00;

        foreach ($cartData as $item) {
            $ref = $item['ref'] ?? null;
            $qty = (int)($item['qty'] ?? 1);

            if (!$ref || $qty < 1) continue;

            $product = $this->productModel->select('id, reference, name, price')->where('reference', $ref)->first();

            if ($product) {
                $price    = (float)$product['price'];
                $subtotal = $price * $qty;
                $grandTotal += $subtotal;

                // 4. Build the validated item object
                $processedItems[] = [
                    'item_id'     => $product['id'],
                    'ref'         => $product['reference'],
                    'name'        => $product['name'],
                    'valid_price' => number_format($price, 2, '.', ''),
                    'qty'         => $qty,
                    'item_total'  => number_format($subtotal, 2, '.', ''),
                ];
            }
        }

        // 5. Return the response
        return $this->response->setJSON([
            'success'     => true,
            'items'       => $processedItems,
            'grand_total' => number_format($grandTotal, 2, '.', '')
        ]);
    }
}