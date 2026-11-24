<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'file_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
