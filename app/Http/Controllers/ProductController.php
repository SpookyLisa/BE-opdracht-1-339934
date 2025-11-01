<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->sp_GetAllProducts();

        return view('products.index', [
            'title' => 'Overzicht Magazijn Jamin',
            'products' => $products
        ]);
    }

    public function leverantieInfo($id)
    {
        $leveringen = $this->productModel->SP_GetLeverancierInfo($id);
        $leverancier = $this->productModel->SP_GetLeverantieInfo($id);

        if (!empty($leveringen) && $leveringen[0]->AantalAanwezig == 0) {
            return view('products.leverantieinfo', [
                'title' => 'Levering Informatie',
                'leveringen' => [],
                'leverancier' => !empty($leverancier) ? $leverancier[0] : null,
                'noStock' => true,
                'nextDelivery' => !empty($leveringen) ? $leveringen[0]->DatumEerstVolgendeLevering : null
            ]);
        }


        return view('products.leverantieinfo', [
            'title' => 'Levering Informatie',
            'leveringen' => $leveringen,
            'leverancier' => !empty($leverancier) ? $leverancier[0] : null,
            'noStock' => false
        ]);
    }
}