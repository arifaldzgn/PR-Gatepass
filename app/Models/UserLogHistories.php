<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogHistories extends Model
{
    use HasFactory;

    protected $fillable = ['action', 'user_id', 'description', 'table_name', 'row_id', 'old_data', 'new_data'];
}
