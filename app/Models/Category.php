<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

	protected $connection = 'mysql';

    protected $fillable = [
       'name',
       'published',
       'vl_prev',
       'day_prev',
       'ordem',
       'type',
    ];

	protected $guarded = ['id'];

}
