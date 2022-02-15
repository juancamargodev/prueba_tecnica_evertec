<?php

namespace App\Http\Controllers;

use App\Repositories\ProductsRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductsController extends Controller
{
    private $productsRepository;

    public function __construct(
        ProductsRepository $productsRepository
    ){
        $this->middleware('auth:api');
        $this->productsRepository = $productsRepository;
    }

    /**
     * @desc Obtiene todos los productos
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(){
        $products = $this->productsRepository->all();
        if(count($products) === 0){
            return $this->responseFail('products are empty', Response::HTTP_NOT_FOUND);
        }
        return $this->responseSuccess($products);
    }

    /**
     * @desc Obtener un producto por su id
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProduct(int $productId){
        $product = $this->productsRepository->find($productId);
        if(count($product) === 0){
            return $this->responseFail('product not found', Response::HTTP_NOT_FOUND);
        }
        return $this->responseSuccess($product);
    }

    /**
     * @desc Crea un nuevo producto
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function createProduct(Request $request){
        try{
            $product = $this->productsRepository->create($request->toArray());
            return $this->responseSuccess($product);
        }catch (\Exception $e){
            return $this->responseFail('error creating product:'.$e->getMessage());
        }
    }

}
