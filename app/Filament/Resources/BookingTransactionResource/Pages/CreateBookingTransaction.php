<?php

namespace App\Filament\Resources\BookingTransactionResource\Pages;

use App\Filament\Resources\BookingTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class CreateBookingTransaction extends CreateRecord
{
    protected static string $resource = BookingTransactionResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Berhasil')
            ->body('Berhasil Membuat Booking Service');
    }

    protected function afterCreate(): void
    {
        // URL webhook Discord
        $webhookUrl = 'https://discord.com/api/webhooks/1327948270923681813/Hr_cRQw5IQdHlWY13cl83TROngH49KmiD1HTthiGYKSvpSGr3Aekx_UWZOyDisQoUnkK';

        // Pesan yang akan dikirim
        $message = [
            'content' => 'Hello, ini adalah notifikasi dari Laravel!',
            'username' => 'Laravel Bot', // Opsional: Nama bot yang akan muncul
            'avatar_url' => 'https://i.imgur.com/AfFp7pu.png', // Opsional: URL avatar
            'embeds' => [
                [
                    'title' => 'Judul Embed',
                    'description' => 'Deskripsi Embed',
                    'url' => 'https://example.com',
                    'color' => 7506394, // Warna dalam format decimal
                    'fields' => [
                        [
                            'name' => 'Field 1',
                            'value' => 'Value 1',
                            'inline' => true,
                        ],
                        [
                            'name' => 'Field 2',
                            'value' => 'Value 2',
                            'inline' => true,
                        ],
                    ],
                ],
            ],
        ];

        // Kirim HTTP POST ke webhook Discord
        $response = Http::post($webhookUrl, $message);
    }
}
