<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SupportTicket
 *
 * @package App\Mail
 */
class SupportTicket extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public string $sender;
    public string $question;

    /**
     * Create a new message instance.
     *
     * @param  string $sender
     * @param  string  $question
     */
    public function __construct(string $sender, string $question)
    {
        $this->sender = $sender;
        $this->question = $question;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.support-ticket');
    }
}
