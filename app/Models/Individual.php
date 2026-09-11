<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Individual extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'birth_place',
        'death_date',
        'death_place',
        'bio',
        'photo'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ($this->last_name ? ' ' . $this->last_name : '');
    }

    public function childrenAsFather(): HasMany
    {
        return $this->hasMany(Relationship::class, 'father_id');
    }

    public function childrenAsMother(): HasMany
    {
        return $this->hasMany(Relationship::class, 'mother_id');
    }

    public function marriagesAsHusband(): HasMany
    {
        return $this->hasMany(Marriage::class, 'husband_id');
    }

    public function marriagesAsWife(): HasMany
    {
        return $this->hasMany(Marriage::class, 'wife_id');
    }

    public function children()
    {
        $children = collect();

        foreach ($this->childrenAsFather as $relation) {
            $children->push($relation->child);
        }

        foreach ($this->childrenAsMother as $relation) {
            $children->push($relation->child);
        }

        return $children->unique('id');
    }

    public function spouse()
    {
        $marriage = $this->marriagesAsHusband->firstWhere('status', 'married')
                    ?? $this->marriagesAsWife->firstWhere('status', 'married');

        if ($marriage) {
            return $marriage->husband_id == $this->id
                ? $marriage->wife
                : $marriage->husband;
        }
        return null;
    }
}
