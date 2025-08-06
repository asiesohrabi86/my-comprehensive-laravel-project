<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;


class Copan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'amount', 'amount_type', 'discount_ceiling', 'type', 'user_id', 'start_date', 'end_date', 'status'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
