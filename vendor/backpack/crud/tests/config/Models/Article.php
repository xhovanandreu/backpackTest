<?php

namespace Backpack\CRUD\Tests\Config\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use CrudTrait;

    protected $table = 'articles';
    protected $fillable = ['id', 'user_id', 'content', 'metas', 'tags', 'extras', 'cast_metas', 'cast_tags', 'cast_extras'];
    protected $casts = [
        'cast_metas' => 'object',
        'cast_tags' => 'object',
        'cast_extras' => 'object',
    ];

    /**
     * Get the author for the article.
     */
    public function user()
    {
        return $this->belongsTo('Backpack\CRUD\Tests\config\Models\User');
    }

    public function getContentComposedAttribute()
    {
        return $this->content.'++';
    }

    public function identifiableAttribute()
    {
        return 'content';
    }
}
