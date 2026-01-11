<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageClick extends Model
{
    protected $fillable = [
        'message_id','user_id','ip','user_agent','device',
        'platform','browser','country','city','latitude','longitude','clicked_at'
    ];
}
