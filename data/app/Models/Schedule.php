<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date'];

    public function getDataByOne(int $userId, string $date): array
    {
        $returnArray = [];

        $all = $this->where('user_id', $userId)->where('date', $date);
        if ($all->exists()) {
            $takeOne = $all->orderBy('id', 'desc')->take(1)->get()->toArray();
            $returnArray = $takeOne[0];
        }

        return $returnArray;
    }

    public function getDataByMany(int $userId, string $date)
    {
        return $this->where('user_id', $userId)->where('date', $date);
    }

    public function getUsersIdToArrayByDate(string $date = 'Y/m/d'): array
    {
        $all = $this->where('date', $date);

        return $all->exists() ? $all->get()->groupBy('user_id')->keys()->toArray() : [];
    }

    public function deleteDateUserRecord(string $date, int $userId)
    {
        $this->where('date', $date)->where('user_id', $userId)->delete();
    }

    public function deleteDeActiveUserRecord(int $userId)
    {
        $this->where('user_id', $userId)->delete();
    }
}
