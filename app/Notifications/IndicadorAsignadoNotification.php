<?php

namespace App\Notifications;

use App\Models\Indicador;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class IndicadorAsignadoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $indicador;

    public function __construct(Indicador $indicador)
    {
        $this->indicador = $indicador;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Nuevo Indicador Asignado')
            ->line('Se te ha asignado un nuevo indicador:')
            ->line($this->indicador->indicador)
            ->action('Ver Indicador', url('/indicadores/' . $this->indicador->cod_indicador))
            ->line('Por favor, ingresa al sistema para completar la información requerida.');
    }
}
