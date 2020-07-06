<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DutyRoster extends Model
{
    protected $table = 'duty_roster';

    public function getData()
    {
        return $this->id;
    }
}
