<?php

namespace App\Models;

use App\Concerns\Likeability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @property int id
 *
 * @package App\Models
 */
class Post extends Model
{
    use HasFactory;
    use Likeability;
}
