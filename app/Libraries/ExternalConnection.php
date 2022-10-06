<?php

namespace App\Libraries;

class ExternalConnection
{
    private $response = [];
    private $responseStatus;

    public function api(string $uri, string $method, array $payload = null)
    {
        $payload['request_time'] =  date("Y-m-d\TH:i:sP");

        $this->payload = $payload;
        $payload = json_encode($payload);

        $url = "http://localhost:3000/api/" . $uri;

        $headerOptions = [
            "Content-Type:application/json",
            "Content-Length:" . strlen($payload),
        ];

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => $headerOptions,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_RETURNTRANSFER => 1
        ]);

        if (ENVIRONMENT !== 'development') {
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        }

        $output = curl_exec($ch);

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errMsg = curl_error($ch);
        $endPoint = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        curl_close($ch);

        return $this->processingOutput($output, $statusCode, $errMsg, $endPoint);
    }

    private function processingOutput($output, $statusCode, $errMsg, $endPoint): bool
    {
        if ($output === FALSE || $statusCode > 299) {
            $response = json_decode($output, true);

            if ($response === false || !isset($response['message'])) {
                $statusCode = $statusCode === 0 ? 500 : $statusCode;
                $response = [$output];
            } else {
                $statusCode = isset($response['code']) ? $response['code'] : $statusCode;
                $errMsg = isset($response['message']) ? $response['message'] : $errMsg;
            }

            log_message('error', "$errMsg - $endPoint");

            $errMsg .= "</br></br> <b>Endpoint:</b></br> " . $endPoint;

            $this->setResponse($statusCode, $errMsg, $response);
            return false;
        }

        $response = json_decode($output, true);

        if (!$response) {
            $this->setResponse(500, "Invalid JSON format. Response: $output");
            return false;
        }

        $this->setResponse($response['code'], $response['message'], @$response['results']);
        return true;
    }

    private function setResponse(int $code, $message, array $data = null)
    {
        $this->responseStatus = $code === 200 ? true : false;

        $response = [
            'success' => $this->responseStatus,
            'code' => $code,
            'message' => $message,
        ];

        if ($data != null) {
            $response['results'] = $data;
        }

        $this->response = $response;
    }

    public function getResponse(): array
    {
        return $this->response;
    }
}
