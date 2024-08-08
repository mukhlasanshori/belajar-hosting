<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Validator;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;


class ProductController extends BaseController
{
    public function index() : JsonResponse{
        $products = product::all();
        return $this->sendResponse(ProductResource::collection($products),'produk terpanggil');
    }
    public function store(Request $request) : JsonResponse {
        $input = $request->all();

        $validator = Validator::make($input,[
            'name' => 'required',
            'deatail' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('validasi gagal.',$validator->errors());

        }
    }
}
