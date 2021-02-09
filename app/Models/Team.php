<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer size
 * @property Collection members
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'size'
    ];
    /**
     * @param  User|Collection  $member
     *
     * @return false|Model|iterable
     *
     * @throws Exception
     */
    public function add($member)
    {
        $this->guardAgainstTooManyMembers();

        $method = $member instanceof User ? 'save': 'saveMany';

        return $this->members()->$method($member);
    }
    /**
     * @param  null  $users
     *
     * @return User|Collection
     */
    public function remove($users = null)
    {
        if ($users instanceof User) {
            return $users->leaveTeam();
        }

        return $this->removeMany($users);
    }

    /**
     * @param $users
     *
     * @return mixed
     */
    public function removeMany($users)
    {
        return $users->each(fn($user) => $user->leaveTeam());
    }

    /**
     *
     * @return Collection
     */
    public function restart() : Collection
    {
        return $this->members->each(fn($member) => $member->leaveTeam());
    }

    public function count() : int
    {
        return $this->members()->count();
    }
    /**
     * @return HasMany
     */
    public function members() : HasMany
    {
        return $this->hasMany(User::class);
    }
    /**
     * @throws Exception
     */
    protected function guardAgainstTooManyMembers() : void
    {
        if ($this->count() >= $this->size) {
            throw new Exception;
        }
    }
}
