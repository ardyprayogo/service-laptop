<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTypes extends Model
{
    use HasFactory;

    protected $table = 'ms_service_types';

    protected $fillable = [
        'type',
        'service_desc'
    ];
}
