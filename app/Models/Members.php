<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    /** @use HasFactory<\Database\Factories\MembersFactory> */
    use HasFactory;
    protected $fillable =['name', 'email', 'phone'];
    public function rentals()
    {
        return $this->hasMany(Rentals::class);
    }
}
