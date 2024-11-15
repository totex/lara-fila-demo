<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    protected $fillable = ['tenant_id', 'property_id', 'num', 'bail',
        'yearly_fee', 'tax', 'pay_term', 'start_date', 'length', 'end_date'];

    public function tenant(): BelongsTo {
        return $this->belongsTo(Tenant::class);
    }

    public function property(): BelongsTo {
        return $this->belongsTo(Property::class);
    }
}
