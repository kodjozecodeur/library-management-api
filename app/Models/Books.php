<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    /** @use HasFactory<\Database\Factories\BooksFactory> */
    use HasFactory;
    protected $fillable = ['title', 'author', 'isbn', 'copies_available'];

    public function rentals(){
        return $this->hasMany(Rentals::class);
    }
}
