<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    

    function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Scope a query to only include deposit
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeposit($query)
    {
        return $query->where('transaction_type','deposit');
    }
    /**
     * Scope a query to only include withdraw
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithdraw($query)
    {
        return $query->where('transaction_type','withdrawal');
    }
}
