<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    protected $fillable = ['type', 'tenant_id', 'area_id', 'number', 'old_num', 'size_m2',
        'evi_start', 'evi_end', 'evi_end_rsn'];

    public function area(): BelongsTo{
        return $this->belongsTo(Area::class);
    }

    public function tenant(): BelongsTo{
        return $this->belongsTo(Tenant::class);
    }

    public function contract(): HasOne {
        return $this->hasOne(Contract::class);
    }

    public function invoice(): HasOne{
        return $this->hasOne(Invoice::class);
    }


    public function getPropertyTypeAttribute()
    {
        if ($this->type == 'parcel'){
            return "parcela";
        }else{
            return "mólo";
        }
    }
}
