<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'file', 'created_by', 'updated_by', 'album_id', 'thumbnail'];

    public function comments()
    {
        return $this->hasMany(FileComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'file_tags');
    }

    public function people()
    {
        return $this->belongsToMany(Person::class, 'file_people');
    }

    public function persons()
    {
        return $this->people();
    }

    public function publications()
    {
        return $this->hasMany(FilePublication::class);
    }

    public function logs()
    {
        return $this->hasMany(FileLog::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function addTag(string $tagName) : void
    {
        $tag = Tag::firstOrCreate([
            'title' => $tagName
        ]);

        $this->tags()->attach($tag);
    }

    public function getThumbnailAttribute($value)
    {
        if (is_null($value)) {
            // It's an image without thumbnail. We give it a new name - so we can't find a thumb and recreate it.
            $extensionFromOriginalFile = \File::extension($this->file);
            $value = \Str::random() . '.' . $extensionFromOriginalFile;
            $this->thumbnail = $value;
            $this->save();
        }
        $fullThumbnailPath = storage_path('app/uploads/' . $value);
        if (!file_exists($fullThumbnailPath)) {
            createThumbnail(storage_path('app/uploads/' . $this->file), $fullThumbnailPath);
            return $this->file;
        }

        return $value;
    }
}
