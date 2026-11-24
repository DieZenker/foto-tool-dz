<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['comment', 'file_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
