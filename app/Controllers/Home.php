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
}
