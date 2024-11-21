<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = ['tenant_id', 'property_id', 'contract_id',
        'number', 'issue_date', 'due_date', 'amount', 'paid'];

    public function tenant(): BelongsTo {
        return $this->belongsTo(Tenant::class);
    }

    public function property(): BelongsTo {
        return $this->belongsTo(Property::class);
    }

    public function contract(): BelongsTo {
        return $this->belongsTo(Contract::class);
    }
}
