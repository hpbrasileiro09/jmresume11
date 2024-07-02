<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{

	protected $table = 'params';

	protected $connection = 'mysql';

    protected $fillable = [
		'label',
		'value',
		'default',
		'dt_params',
		'type',
    ];

	protected $guarded = ['id'];

}
