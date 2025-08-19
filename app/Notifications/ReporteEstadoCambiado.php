<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\IndicadorMensual;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReporteEstadoCambiado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public IndicadorMensual $reporte)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Cambio de estado de reporte mensual')
            ->line("Indicador {$this->reporte->cod_indicador} – Mes {$this->reporte->mes}/{$this->reporte->año}")
            ->line("Nuevo estado: {$this->reporte->estado}")
            ->action('Ver reporte', url(route('reportes.show', [$this->reporte->cod_indicador, $this->reporte->año, $this->reporte->mes])));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
