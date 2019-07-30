<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Flugg\Responder\Contracts\Transformable;

class Product extends Model implements Transformable
{
    /**
     * O nome da tabela correspondente ao modelo no banco de dados.
     * 
     * @var string
     */
    protected $table = 'products';

    /**
     * As colunas que poderão ser preenchidas em massa.
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'price', 'weight' ];

    /**
     * As colunas que deverão ser ocultadas do objeto retornado pela busca.
     * 
     * @var array
     */
    protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * Realiza a transformação do produto para retorno.
     * 
     * @return callable
     */
    public function transformer() {
        return function ($product) {
            return [
                'id'     => (int) $product->id,
                'name'   => $product->name,
                'price'  => (float) $product->price,
                'weight' => (float) $product->weight,
                'links'  => [
                    'uri' => "/products/$product->id"
                ]
            ];
        };
    }
}
