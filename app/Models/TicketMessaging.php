<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMessaging extends Model
{
    use HasFactory;
    protected $table = 'tbl_ticket_reply';
    protected $primaryKey = 'id';
    protected $fillable =[
        'ticket_id',
        'reply',
        'user_id',
        'created_on'
    ];
}
