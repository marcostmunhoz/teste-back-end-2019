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
        return response()->json([ 'data' => Product::all() ]);
    }

    /**
     * Retorna as informações de um produto, de acordo com o filtro.
     * 
     * @param int $id O ID do produto buscado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        try {
            if (!$id) {
                return response()->json([ 'message' => 'Nenhum ID foi fornecido.' ], 400);
            }

            $product = Product::find($id);
            if (!$product) {
                return response()->json([ 'message' => "Nenhum produto foi localizado para o ID $id." ], 404);
            }

            return response()->json([ 'data' => $product ]);
        } catch (Exception $ex) {
            return response()->json([ 'error' => $ex->getMessage() ], 500);
        }
    }

    /**
     * Realiza o cadastro de um novo produto.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'   => 'required:price,weight',
                'price'  => 'required:name,weight',
                'weight' => 'required:name,price'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->getMessageBag(), 400);
            }

            $product = Product::insert($data);

            return response()->json([ 'message' => 'Produto cadastrado com sucesso.' ], 201);
        } catch (Exception $ex) {
            return response()->json([ 'error' => $ex->getMessage() ], 500);
        }
    }
    
    /**
     * Realiza a atualização de um produto cadastrado.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request) {
        try {
            if (!$id) {
                return response()->json([ 'message' => 'Nenhum ID foi fornecido.' ], 400);
            }

            $product = Product::find($id);
            if (!$product) {
                return response()->json([ 'message' => "Nenhum produto foi localizado para o ID $id." ], 404);
            }

            $data = $request->all();
            $validator = Validator::make($data, [
                'name'   => 'required_without_all:price,weight|string',
                'price'  => 'required_without_all:name,weight|numeric',
                'weight' => 'required_without_all:name,price|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->getMessageBag(), 400);
            }

            $product->fill($data);
            $product->save();

            return response()->json([ 'message' => 'Produto atualizado com sucesso.' ]);
        } catch (Exception $ex) {
            return response()->json([ 'error' => $ex->getMessage() ], 500);
        }
    }

    /**
     * Realiza a exclusão do produto.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        try {
            if (!$id) {
                return response()->json([ 'message' => 'Nenhum ID foi fornecido.' ], 400);
            }

            $product = Product::find($id);
            if (!$product) {
                return response()->json([ 'message' => "Nenhum produto foi localizado para o ID $id." ], 404);
            }

            $product->delete();

            return response()->json([ 'message' => 'Produto deletado com sucesso.' ]);
        } catch (Exception $ex) {
            return response()->json([ 'message' => $ex->getMessage() ]);
        }
    }
}
