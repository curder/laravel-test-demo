<?php

namespace Tests\Feature;

use App\Mail\SupportTicket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * Class SupportTest
 *
 * @package Tests\Feature
 */
class SupportTest extends TestCase
{

    /** @test */
    public function it_sends_a_support_email(): void
    {
        Mail::fake();

        $this->contact($fields = $this->validFields())
            ->assertRedirect('/')
            ->assertSessionHas('message');

        Mail::assertQueued(SupportTicket::class, function ($mail) use ($fields) {
            return $mail->sender === $fields['email'];
        });
    }

    /** @test */
    public function it_requires_a_name(): void
    {
        $this->contact(['name' => ''])->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_requires_a_valid_email(): void
    {
        $this->contact(['email' => 'not-an-email'])->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_requires_a_question(): void
    {
        $this->contact(['question' => ''])
             ->assertSessionHasErrors(['question']);
    }

    /**
     * 构建请求
     *
     * @param  array  $attributes
     *
     * @return \Illuminate\Testing\TestResponse
     */
    protected function contact($attributes = []) : TestResponse
    {
        $this->withExceptionHandling();

        return $this->post('/contact', $this->validFields($attributes));
    }

    /**
     * @param  array  $override
     *
     * @return string[]
     */
    protected function validFields(array $override = []) : array
    {
        return array_merge([
            'name' => 'john doe',
            'email' => 'john@example.com',
            'question' => 'Help me.',
        ], $override);
    }
}
