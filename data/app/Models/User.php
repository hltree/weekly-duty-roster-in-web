<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_schedule_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserByOne(int $userId)
    {
        $all = $this->where('id', $userId);
        if ($all->exists()) {
            $takeOne = $all->take(1)->orderBy('id', 'desc')->get();

            return $takeOne[0];
        }

        return null;
    }

    public function getBasicUsers(): Collection
    {
        return $this->where('is_admin', '!=', 1)->orWhereNull('is_admin')->get();
    }

    public function getScheduleActiveUsers(bool $excludeAdminUser = true): Collection
    {
        $all = $this->where('is_schedule_active', 1);
        if (true === $excludeAdminUser) {
            $all = $all->where(function ($query) {
                $query->where('is_admin', '!=', 1)->orWhereNull('is_admin');
            });
        }

        return $all->get();
    }

    public function getScheduleActiveUsersId(bool $excludeAdminUser = true): array
    {
        $all = $this->where('is_schedule_active', 1);
        if (true === $excludeAdminUser) {
            $all = $all->where(function ($query) {
                $query->where('is_admin', '!=', 1)->orWhereNull('is_admin');
            });
        }

        return $all->exists() ? $all->get()->groupBy('id')->keys()->toArray() : [];
    }

    public function isAdmin(int $userId): bool
    {
        $takeOne = $this->where('id', $userId)->take(1);
        return $takeOne->exists() && 1 === $takeOne->get()->toArray()[0]['is_admin'] ? true : false;
    }
}
