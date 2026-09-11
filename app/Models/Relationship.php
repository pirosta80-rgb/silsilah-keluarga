<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Relationship extends Model
{
    protected $fillable = [
        'child_id',
        'father_id',
        'mother_id',
        'marriage_id',
        'relationship_type'
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Individual::class, 'child_id');
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Individual::class, 'father_id');
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Individual::class, 'mother_id');
    }

    public function marriage(): BelongsTo
    {
        return $this->belongsTo(Marriage::class);
    }

    public function getParentsAttribute()
    {
        $parents = [];
        if ($this->father) $parents[] = $this->father;
        if ($this->mother) $parents[] = $this->mother;
        return $parents;
    }
}
