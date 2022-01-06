<?php

namespace Tests\Feature\Browsers;

use Tests\BrowserTestCase;

/**
 * Class ExampleTest
 *
 * @package \Tests\Feature\Browsers
 */
class ExampleTest extends BrowserTestCase
{
    /** @test */
    public function it_has_a_link_feedback(): void
    {
        $this->visit('/')
             ->click('Click Me')
             ->see('You\'ve been clicked, punk.')
             ->seePageIs('feedback');
    }
}
