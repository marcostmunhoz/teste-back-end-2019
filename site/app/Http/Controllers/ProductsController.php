<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Product;
use Exception;

class ProductsController extends Controller
{
    /**
     * Retorna a lista com todos os produtos
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAll() {
        return responder()->success(Product::all())->respond();
    }

    /**
     * Retorna as informações de um produto, de acordo com o filtro.
     * 
     * @param int $id O ID do produto buscado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $product = Product::find($id);
        if (!$product) {
            return responder()->error('product_not_found')->data([ 'id' => $id ])->respond(404);
        }

        return responder()->success($product)->respond();
    }

    /**
     * Realiza o cadastro de um novo produto.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $data = $request->validate([
            'name'   => 'required|string',
            'price'  => 'required|numeric',
            'weight' => 'required|numeric'
        ]);

        $product = new Product($data);
        $product->save();

        return responder()->success($product)->respond(201);
    }
    
    /**
     * Realiza a atualização de um produto cadastrado.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request) {
        $product = Product::find($id);
        if (!$product) {
            return responder()->error('product_not_found')->data([ 'id' => $id ])->respond(404);
        }

        $data = $request->validate([
            'name'   => 'required_without_all:price,weight',
            'price'  => 'required_without_all:name,weight',
            'weight' => 'required_without_all:name,price'
        ]);

        $product->fill($data);
        $product->save();

        return responder()->success($product)->respond();
    }

    /**
     * Realiza a exclusão do produto.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        $product = Product::find($id);
        if (!$product) {
            return responder()->error('product_not_found')->data([ 'id' => $id ])->respond(404);
        }
        
        $product->delete();

        return responder()->success([ 'message' => 'Produto excluído com sucesso.' ])->respond();
    }
}
