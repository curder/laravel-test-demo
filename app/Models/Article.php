<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @method static trending()
 *
 * @package App\Models
 */
class Article extends Model
{
    use HasFactory;

    public function scopeTrending(\Illuminate\Database\Eloquent\Builder $query, $take = 3)
    {
        return $query->orderByDesc('reads')->take($take)->get();
    }
}
