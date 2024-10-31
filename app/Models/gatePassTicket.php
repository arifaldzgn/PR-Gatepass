<?php

namespace App\Models;

use App\Models\gatePassRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class gatePassTicket extends Model
{
    use HasFactory;

    protected $guarded =
    [
        'id'
    ];

    public function gatePassRequest()
    {
        return $this->hasMany(gatePassRequest::class, 'ticket_id');
    }

}
