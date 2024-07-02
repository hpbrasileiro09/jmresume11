<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{

    protected $table = 'entries';

    protected $connection = 'mysql';
    
    protected $fillable = [
       'id_category',
       'dt_entry',
       'vl_entry',
       'nm_entry',
       'ds_category',
       'ds_subcategory',
       'status',
       'fixed_costs',
       'checked',
       'published',
       'ds_detail',
    ];

	protected $guarded = ['id'];

  public function category()
  {
      return $this->hasOne(Category::class, 'id', 'id_category');
  }

}
