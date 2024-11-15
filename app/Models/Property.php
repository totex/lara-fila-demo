<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $fillable = ['type', 'tenant_id', 'area_id', 'num', 'old_num', 'size_m2',
        'evi_start', 'evi_end', 'evi_end_reason'];

    public function tenant(): BelongsTo{
        return $this->belongsTo(Tenant::class);
    }

    public function area(): BelongsTo{
        return $this->belongsTo(Area::class);
    }

    public function invoice(): BelongsTo{
        return $this->belongsTo(Invoice::class);
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
