<?php

namespace App\Models;

use App\Concerns\Likeability;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Post
 *
 * @property integer id
 *
 * @package App\Models
 */
class Post extends Model
{
    use HasFactory;
    use Likeability;
}
