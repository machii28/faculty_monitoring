<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'rooms';
    protected $guarded = ['id'];

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'room_id', 'id');
    }
}
