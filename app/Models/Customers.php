<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $table = 'ms_customers';

    protected $fillable = [
        'customer',
        'telp',
        'email',
        'gender',
        'address'
    ];
}
