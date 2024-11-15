<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['first_name', 'last_name', 'address', 'iban'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
