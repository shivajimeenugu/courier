<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class couries extends Model
{
    protected $table = 'couries';

    use HasFactory;
    protected $fillable = [
        'billid',
        'cdate',
        'amount',
        'cfrom',
        'cto',
        'csender',
        'creciver'
    ];
}
