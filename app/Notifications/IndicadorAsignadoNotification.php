<?php

namespace App\Notifications;

use App\Models\Indicador;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class IndicadorAsignadoNotification extends Notification
{
    public function __construct(public Indicador $indicador)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Nuevo indicador asignado')
            ->greeting('Hola ' . ($notifiable->nombre ?? ''))
            ->line('Se te ha asignado el indicador: ' . $this->indicador->indicador)
            ->action('Ver indicador', route('indicadores.show', ['indicador' => $this->indicador->cod_indicador]));
    }
}
