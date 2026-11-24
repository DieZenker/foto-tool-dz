<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_publications');
    }

    public function delete()
    {
        $files = $this->files()->with('publications')->get();
        foreach ($files as $file) {
            $publications = $file->publications()->where('platform_id', $this->id)->get();
            foreach ($publications as $publication) {
                $publication->delete();
            }
        }

        return parent::delete();
    }
}
