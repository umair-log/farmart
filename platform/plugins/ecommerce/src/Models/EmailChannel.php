<?php

namespace Botble\Ecommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'status',
        // 'gaming_account_id',
    ];

    public function gamingAccount()
    {
        return $this->belongsTo(GamingAccount::class);
    }
}
