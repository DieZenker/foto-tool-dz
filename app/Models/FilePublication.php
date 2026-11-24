<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilePublication extends Model
{
    use HasFactory;

    protected $fillable = ['platform_id', 'file_id', 'comment', 'publication_date', 'link'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
