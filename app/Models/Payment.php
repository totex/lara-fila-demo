<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['tenant_id', 'invoice_id', 'amount', 'date_received', 'iban'];

    public function tenant(): BelongsTo {
        return $this->belongsTo(Tenant::class);
    }

    public function invoice(): BelongsTo {
        return $this->belongsTo(Invoice::class);
    }
}
