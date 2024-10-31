<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\deptList;
use App\Models\UserLogHistories;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'deptList_id',
        'badge_no',
        'role',
        'password',
        'email'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function deptList()
    {
        return $this->belongsTo(deptList::class, 'deptList_id');
    }


    protected static function boot()
    {
        parent::boot();

        self::created(function($user) {
            UserLogHistories::create([
                'action' => 'create',
                'user_id' => auth()->id(),
                'description' => 'User created',
                'table_name' => 'users',
                'row_id' => $user->id,
                'new_data' => $user->toJson(),
            ]);
        });

        self::updated(function($user) {
            $changes = $user->getChanges();
            $oldData = array_intersect_key($user->getOriginal(), $changes);

            UserLogHistories::create([
                'action' => 'update',
                'user_id' => auth()->id(),
                'description' => 'User updated',
                'table_name' => 'users',
                'row_id' => $user->id,
                'old_data' => json_encode($oldData),
                'new_data' => json_encode($changes),
            ]);
        });

        self::deleted(function($user) {
            UserLogHistories::create([
                'action' => 'delete',
                'user_id' => auth()->id(), 
                'description' => 'User deleted',
                'table_name' => 'users',
                'row_id' => $user->id,
                'old_data' => $user->toJson(),
            ]);
        });
    }
}
