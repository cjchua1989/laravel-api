<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $connection = "cms_mysql";
    protected $appends = [
        'url',
    ];

    use HasFactory;

    public function getThumbnailAttribute($value) {
        return Storage::disk('public')->url($value);
    }

    public function getUrlAttribute() 
    {
        return App::make('url')->to("/api/pages/{$this->slug}");
    }
}
