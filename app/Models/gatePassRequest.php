<?php

namespace App\Models;

use App\Models\gatePassTicket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class gatePassRequest extends Model
{
    use HasFactory;

    protected $guarded =
    [
        'id'
    ];

    public function gatePassTicket()
    {
        return $this->belongsTo(gatePassTicket::class ,'ticket_id', 'id');
    }
}
