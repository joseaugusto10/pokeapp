<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pokemon extends Model
{
    protected $table = 'pokemons';

    protected $fillable = [
        'api_id',
        'name',
        'height',
        'weight',
        'sprite',
    ];

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'pokemon_type');
    }

    public function favoritos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pokemon_user_favorite')
            ->withTimestamps();
    }

}
