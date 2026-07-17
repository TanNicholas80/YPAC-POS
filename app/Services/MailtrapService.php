<?php

namespace App\Services;

use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
use Illuminate\Support\Facades\Log;

class MailtrapService
{
    protected string $apiKey;
    protected bool $isSandbox;
    protected ?int $inboxId;
    protected string $recipientEmail;

    public function __construct()
    {
        $this->apiKey = config('services.mailtrap.api_key', '');
        $this->isSandbox = (bool) config('services.mailtrap.use_sandbox', false);
        
        $inboxVal = config('services.mailtrap.inbox_id');
        $this->inboxId = $inboxVal !== null ? (int) $inboxVal : null;
        
        // Recipient email for contact form submissions
        $this->recipientEmail = 'ypacsemarangyes@gmail.com';
    }

    /**
     * Send contact form email submission.
     *
     * @param string $name
     * @param string $email
     * @param string $topic
     * @param string $messageContent
     * @return bool
     */
    public function sendContactEmail(string $name, string $email, string $topic, string $messageContent): bool
    {
        try {
            // Set up custom Guzzle client (disable SSL verification in Sandbox to avoid Windows cURL error 60)
            $guzzleClient = new \GuzzleHttp\Client([
                'verify' => !$this->isSandbox,
            ]);

            $config = new \Mailtrap\Config($this->apiKey);
            $config->setHttpClient($guzzleClient);
            $mailtrap = new MailtrapClient($config);

            $emailSender = $this->isSandbox 
                ? $mailtrap->sandbox()->emails($this->inboxId) 
                : $mailtrap->sending()->emails();

            $fromAddress = $this->isSandbox 
                ? 'sandbox@example.com' 
                : config('mail.from.address', 'admin@karyaypac.org');
            $fromName = config('mail.from.name', 'KUBE YPAC');

            $dateStr = now()->translatedFormat('d F Y, H:i') . ' WIB';

            // Render plain text and HTML bodies from separate Blade views
            $plainTextBody = view('emails.contact_plain', compact('name', 'email', 'topic', 'messageContent', 'dateStr'))->render();
            $htmlBody = view('emails.contact', compact('name', 'email', 'topic', 'messageContent', 'dateStr'))->render();

            $subject = "Pesan Hubungi Kami Baru: {$topic} - {$name}";

            $emailMessage = (new MailtrapEmail())
                ->from(new Address($fromAddress, $fromName))
                ->to(new Address($this->recipientEmail, 'YPAC Semarang'))
                ->replyTo(new Address($email, $name))
                ->subject($subject)
                ->text($plainTextBody)
                ->html($htmlBody);

            $emailSender->send($emailMessage);
            return true;
        } catch (\Exception $e) {
            Log::error('MailtrapService Error sending contact email: ' . $e->getMessage(), [
                'exception' => $e,
                'name' => $name,
                'email' => $email
            ]);
            return false;
        }
    }
}
