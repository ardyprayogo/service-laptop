<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrServiceD extends Model
{
    use HasFactory;

    protected $table = 'tr_service_d';

    protected $fillable = [
        'service_h_id',
        'service_id',
        'service_type_id',
        'price'
    ];
}
