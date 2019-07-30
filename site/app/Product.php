<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
}
