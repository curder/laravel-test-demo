<?php

namespace Tests\Unit\Integration\Models;

use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Class TeamTest
 *
 * @package Tests\Unit\Integration\Models
 */
class TeamTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_name(): void
    {
        $team = Team::factory()->create(['name' => 'Acme']);

        self::assertEquals('Acme', $team->name);
    }

    /** @test */
    public function it_can_add_members(): void
    {
        $team = Team::factory()->create();

        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $team->add($user);
        $team->add($anotherUser);

        self::assertEquals(2, $team->count());
    }

    /** @test */
    public function it_has_a_maximum_size(): void
    {
        $team = Team::factory()->create(['size' => 2]);

        $user = User::factory()->create();
        $userTwo = User::factory()->create();

        $team->add($user);
        $team->add($userTwo);

        self::assertEquals(2, $team->count());

        $this->expectException(Exception::class);
        $userThree = User::factory()->create();
        $team->add($userThree);
    }

    /** @test */
    public function it_can_add_multiple_members_at_once(): void
    {
        $team = Team::factory()->create();

        $users = User::factory(2)->create();

        $team->add($users);

        self::assertEquals(2, $team->count());
    }

    /** @test */
    public function it_can_remove_a_member(): void
    {
        $team = Team::factory()->create();

        $users = User::factory(2)->create();

        $team->add($users);

        $team->remove($users->first());
        self::assertEquals(1, $team->count());
    }

    /** @test */
    public function it_can_remove_more_then_one_members(): void
    {
        $team = Team::factory()->create(['size' => 3]);

        $users = User::factory(3)->create();

        $team->add($users);

        $team->remove($users->slice(0, 2));

        self::assertEquals(1, $team->count());
    }

    /** @test */
    public function it_can_remove_all_members_at_once(): void
    {
        $team = Team::factory()->create();

        $users = User::factory(2)->create();

        $team->add($users);

        $team->restart();
        self::assertEquals(0, $team->count());
    }
}
