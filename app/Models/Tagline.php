<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tagline extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'tagline';

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $fillable = [
        'service_id',
        'tagline',
        'updated_at',
        'created_at',
        'deleted_at',

    ];

       // One to Many
    public function service()
    {
        return $this->belongsTo('App/Models/Service', 'service_id', 'id');
    }
}
