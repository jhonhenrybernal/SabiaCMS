<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content','author','language','source'];

    public function clicks()
    {
        return $this->hasMany(MessageClick::class);
    }
}
