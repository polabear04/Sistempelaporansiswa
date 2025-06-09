<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    /**
     * Create a new notification instance.
     *
     * @param  string  $token
     */
    public function __construct($token)
    {
        parent::__construct($token); // penting agar $this->token tersedia
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Permintaan Reset Password')
            ->greeting('Halo, ' . $notifiable->name . ' 👋')
            ->line('Kami menerima permintaan untuk mereset password akun Anda.')
            ->action('Reset Password Sekarang', url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->salutation('Terima kasih, tim ' . config('app.name'));
    }
}
