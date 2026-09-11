<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marriage extends Model
{
    protected $fillable = [
        'husband_id',
        'wife_id',
        'marriage_date',
        'divorce_date',
        'marriage_place',
        'status',
        'notes'
    ];

    public function husband(): BelongsTo
    {
        return $this->belongsTo(Individual::class, 'husband_id');
    }

    public function wife(): BelongsTo
    {
        return $this->belongsTo(Individual::class, 'wife_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Relationship::class, 'marriage_id');
    }

    public function getSpouse($individualId)
    {
        if ($this->husband_id == $individualId) {
            return $this->wife;
        }
        if ($this->wife_id == $individualId) {
            return $this->husband;
        }
        return null;
    }
}
