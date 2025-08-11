<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentals extends Model
{
    /** @use HasFactory<\Database\Factories\RentalsFactory> */
    use HasFactory;
    protected $fillable =[
        "book_id",
        "member_id",
        "rented_at",
        "due_at",
        "returned_at"
    ];
    public function book()
    {
        return $this->belongsTo(Books::class);
    }
    public function member()
    {
        return $this->belongsTo(Members::class);
    }
}
