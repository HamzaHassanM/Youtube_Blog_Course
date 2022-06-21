<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Model implements  TranslatableContract
{
    use Translatable , HasEagerLimit , HasFactory , SoftDeletes;


    public $translatedAttributes = ['title', 'content'];
    protected $fillable = [ 'id', 'image', 'parent', 'created_at', 'updated_at', 'deleted_at'];

    public function parents()
    {
        return $this->belongsTo(Category::class,'parent');
    }
    
    public function children()
    {
        return $this->hasMany(Category::class,'parent');
    }

    public function posts()
    {
       return $this->hasMany(Post::class);
    }

}
