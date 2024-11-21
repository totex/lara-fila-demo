<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contract extends Model
{
    protected $fillable = ['tenant_id', 'property_id', 'number', 'bail',
        'yearly_fee', 'tax', 'pay_term', 'start_date', 'length', 'end_date'];

    public function tenant(): BelongsTo {
        return $this->belongsTo(Tenant::class);
    }

    public function property(): BelongsTo {
        return $this->belongsTo(Property::class);
    }

    public function invoice(): HasOne {
        return $this->hasOne(Invoice::class);
    }
}
