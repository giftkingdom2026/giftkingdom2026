<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;

class EventInquiry extends Model
{
    protected $table = 'event_inquiries';

    protected $fillable = [
        'name',
        'email',
        'guest_count',
        'event_date',
        'event',
        'phone',
        'message',
        'event',
    ];
}
