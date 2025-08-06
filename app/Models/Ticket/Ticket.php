<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Ticket\TicketAdmin;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['subject', 'description','status', 'seen','reference_id', 'user_id','category_id', 'priority_id', 'ticket_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(TicketAdmin::class, 'reference_id');
    }

    public function priority() {
        return $this->belongsTo(TicketPriority::class);
    }

    public function category() {
        return $this->belongsTo(TicketCategory::class);
    }

    public function parent() {
        return $this->belongsTo(Ticket::class, 'ticket_id')->with('parent');
    }

    public function children() {
        return $this->hasMany(Ticket::class, 'ticket_id')->with('children');
    }
}
