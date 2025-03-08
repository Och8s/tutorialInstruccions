<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    /** @use HasFactory<\Database\Factories\GuideFactory> */
    use HasFactory;

    protected $table = 'guides';

    protected $fillable = [
        'guide_id',
        'title',
        'category',
        'subject',
        'summary',
        'introduction_raw',
        'introduction_rendered',
        'conclusion_raw',
        'conclusion_rendered',
        'difficulty',
        'time_required_min',
        'time_required_max',
        'public',
        'locale',
        'type',
        'url',
        'documents',
        'flags',
        'image',
        'prerequisites',
        'steps',
        'tools',
        'author_id',
        'author_username',
        'author_image',
        'created_date',
        'published_date',
        'modified_date',
        'prereq_modified_date',
    ];

    protected $casts = [
        'documents' => 'array',
        'flags' => 'array',
        'image' => 'array',
        'prerequisites' => 'array',
        'steps' => 'array',
        'tools' => 'array',
        'author_image' => 'array',
        'public' => 'boolean',
        'created_date' => 'datetime',
        'published_date' => 'datetime',
        'modified_date' => 'datetime',
        'prereq_modified_date' => 'datetime',
    ];
}
