<?php
namespace App\Concerns;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait Likeability
 * @property MorphMany likes
 *
 * @package App\Concerns
 */
trait Likeability
{
    public function likes() : MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * @return false|Model
     */
    public function like()
    {
        $like = new Like(['user_id' => Auth::id()]);

        return $this->likes()->save($like);
    }

    /**
     * set current model unlike
     * @return mixed
     */
    public function unlike()
    {
        return $this->likes()->where('user_id', Auth::id())->delete();
    }

    /**
     * toggle like status
     *
     * @return false|Model|mixed
     */
    public function toggle()
    {
        return $this->isLiked() ? $this->unlike(): $this->like();
    }

    /**
     * fetch count of current user likes.
     * @return int
     */
    public function getLikesCountAttribute(): int
    {
        return $this->likes->count();
    }

    /**
     * @return bool
     */
    public function isLiked() : bool
    {
        return $this->likes()->where('user_id', Auth::id())->count();
    }
}
