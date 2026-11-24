<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'parent_id'
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function parent()
    {
        return $this->belongsTo(Album::class, 'parent_id', 'id');
    }

    public function subAlbums()
    {
        return $this->hasMany(Album::class, 'parent_id', 'id');
    }

    public function hasSubAlbums()
    {
        if ($this->subAlbums->count())
            return true;
        return false;
    }

    public function getUrl()
    {
        return route('album.show', $this);
    }

    public function getBreadcrumps($linkClass='', $setLinks=true)
    {
        $breadcrumStr = '';

        $parent = $this->parent;
        while (!is_null($parent)) {
            if ($setLinks)
                $breadcrumStr = '<a href="'.$parent->getUrl().'">' . $parent->name . '</a> >> ' . $breadcrumStr;
            else
                $breadcrumStr = $parent->name . ' >> ' . $breadcrumStr;
            $parent = $parent->parent;
        }

        if ($setLinks)
            $breadcrumStr = '<a href="'.route('dashboard').'">Dashboard</a> >> ' . $breadcrumStr . '<a href="'.$this->getUrl().'">' . $this->name . '</a>';
        else
            $breadcrumStr = 'Dashboard >> ' . $breadcrumStr . $this->name;

        return $breadcrumStr;
    }
}
