<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['name','author_id','category_id'];
    protected $guarded = ['id'];

    public function Category(){
        return $this->belongsTo(Category::class);
    }
    public function Author(){
        return $this->belongsTo(Author::class);
    }

}
