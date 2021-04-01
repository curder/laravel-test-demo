<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int size
 * @property Collection members
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'size',
    ];

    /**
     * @param  User|Collection  $users
     *
     * @return false|Model|iterable
     *
     * @throws Exception
     */
    public function add($users)
    {
        $this->guardAgainstTooManyMembers($users);

        $method = $users instanceof User ? 'save': 'saveMany';

        return $this->members()->$method($users);
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
        return $users->each(function ($user) {
            return $user->leaveTeam();
        });
    }

    /**
     *
     * @return Collection
     */
    public function restart() : Collection
    {
        return $this->members->each(function ($member) {
            return $member->leaveTeam();
        });
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
     * @param User|Collection $users
     *
     * @throws \Exception
     */
    protected function guardAgainstTooManyMembers($users) : void
    {
        $numUserToAdd = ($users instanceof User) ? 1: count($users);
        $newTeamCount = $this->count() + $numUserToAdd;

        if ($newTeamCount > $this->size) {
            throw new Exception;
        }
    }
}
