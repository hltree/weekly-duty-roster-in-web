<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['name', 'exclude_week'];

    public function getData()
    {
        return $this->id;
    }
}
