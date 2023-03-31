<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public function clients()
    {
        return $this->belongsToMany(Client::class);
        /*
        Si queremos dar otro nombre la tabla pivote
            return $this->belongsToMany(Client::class, 'compra');
        */
    }
}
