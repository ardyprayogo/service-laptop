<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'ms_services';

    protected $fillable = [
        'service_type_id',
        'service',
        'price',
        'desc'
    ];
}
