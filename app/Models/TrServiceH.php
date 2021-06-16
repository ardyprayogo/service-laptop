<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrServiceH extends Model
{
    use HasFactory;

    protected $table = 'tr_service_h';

    protected $fillable = [
        'service_code',
        'total_price',
        'user_id',
        'customer_id',
        'down_payment',
        'laptop',
        'date_time',
        'case'
    ];
}
