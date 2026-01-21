<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    /**
     * Send a message via WhatsApp API using a template.
     *
     * @param string $phone
     * @param string $templateName
     * @param array $params
     * @return mixed
     */
    public function sendMessage($phone, $templateName, $params)
    {
            $response = $this->sendToWhatsAppAPI($phone, $templateName, $params);
            return $response;
    }

    /**
     * Call WhatsApp API to send message using template.
     *
     * @param string $phone
     * @param string $templateName
     * @param array $params
     * @return mixed
     */
    private function sendToWhatsAppAPI($phone, $templateName, $params)
    {
        // Prepare the API request body
        $data = [
            'to' => $phone,
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => 'en',
                ],
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => $this->prepareTemplateParameters($params),
                    ],
                ],
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => env('WHATSAPP_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('WHATSAPP_API_URL'), $data);

        return $response->json();
    }

    /**
     * Prepare the template parameters (if any) dynamically.
     *
     * @param array $params
     * @return array
     */
    private function prepareTemplateParameters($params)
    {
        // Dynamically prepare the parameters for the template
        $parameters = [];

        foreach ($params as $key => $value) {
            $parameters[] = [
                'type' => 'text',
                'text' => $value,
            ];
        }

        return $parameters;
    }
}
