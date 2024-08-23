<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use App\Classes\ResponseClass;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepository $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function index() 
    {
        $data = $this->productRepositoryInterface->index();

        return ResponseClass::sendResponse(ProductResource::collection($data),'',200);
    }

    public function create()
    {

    }

    public function store(StoreProductRequest $request)
    {
        $details = [
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->store($details);
            DB::commit();
            return ResponseClass::sendResponse(new ProductResource($product),'Product Create Successful',201);
        } catch(\Exception $ex){
            return ResponseClass::rollback($ex);
          }
    }

    public function show($id)
    {
        $product = $this->productRepositoryInterface->getById($id);

        return ResponseClass::sendResponse(new ProductResource($product),'',200);
    }
    
    public function edit(Product $product)
    {

    }

    public function update(UpdateProductRequest $request, $id)
    {
        $updateDetails = [
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->update($updateDetails,$id);

            DB::commit();
            return ResponseClass::sendResponse('Product Updated Successful','',201);
        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    public function destroy($id)
    {
        $this->productRepositoryInterface->delete($id);

        return ResponseClass::sendResponse('Product Delete Successful','',204);
    }
}
