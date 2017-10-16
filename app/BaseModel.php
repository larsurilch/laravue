<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BaseModel extends Model
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y - H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y - H:i:s');
    }
}
