<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Media\MediaRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory,
        MediaRelation;

    protected $table = 'medias';

    protected $fillable = [
        'mediaable_id',
        'mediaable_type',
        'path',
        'is_active'
    ];
}
