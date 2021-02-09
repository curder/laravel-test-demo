<?php

namespace Tests\Unit\Integration\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class LikeTest
 *
 * @package Tests\Unit\Integration\Models
 */
class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Post
     */
    protected $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = createPost();
        $this->signIn();
    }

    /** @test */
    public function a_user_can_like_a_post(): void
    {
        $this->post->like();

        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'likeable_type' => get_class($this->post),
            'likeable_id' => $this->post->id,
        ]);

        self::assertTrue($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post(): void
    {
        $this->post->like();
        $this->post->unlike();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'likeable_type' => get_class($this->post),
            'likeable_id' => $this->post->id,
        ]);

        self::assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_toggle_a_post_like_status(): void
    {
        $this->post->toggle();
        self::assertTrue($this->post->isLiked());

        $this->post->toggle();
        self::assertFalse($this->post->isLiked());

    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has(): void
    {
        $this->post->toggle();

        self::assertEquals(1, $this->post->likesCount);
    }
}
