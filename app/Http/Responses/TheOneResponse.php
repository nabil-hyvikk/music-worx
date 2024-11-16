<?php
namespace App\Http\Responses;
use Illuminate\Contracts\Support\Responsable;

class TheOneResponse implements Responsable
{
    protected int $httpCode;
    protected array $data;
    protected string $errorMessage;
    protected string $message;

    public function __construct(int $httpCode, array $data = [], string $errorMessage = '', $message='')
    {

        if (! (($httpCode >= 200 && $httpCode <= 300) || ($httpCode >= 400 && $httpCode <= 600))) {
          throw new \RuntimeException($httpCode . ' is not valid');
        }

        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->errorMessage = $errorMessage;
        $this->message = $message;
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        $payload = match (true) {
            $this->httpCode >= 500 => ['error_message' => 'Server error'], //if you don't show server errors to all
            $this->httpCode >= 400 => ['error_message' => $this->errorMessage],
            $this->httpCode >= 200 => ['data' => $this->data, 'message' => $this->message],
            //... add your logic to this block
        };

        return response()->json(
            data: $payload,
            status: $this->httpCode,
            options: JSON_UNESCAPED_UNICODE
        );
    }

    public static function ok(array $data, $message = 'success')
    {
        return new static(200, $data,  message: $message);
    }

    public static function created(array $data, $message = 'Created sucessfully')
    {
        return new static(201, $data, message: $message);
    }

    public static function notFound(string $errorMessage = "Item not found")
    {
        return new static(404, errorMessage: $errorMessage);
    }

    //add any other static methods here
    public static function InvalidCredential(string $errorMessage = "Invalid Credentials")
    {
        return new static(401, errorMessage: $errorMessage);
    }

    public static function other($httpCode,$data=[], $message = 'failed request')
    {
        return new static($httpCode,$data, errorMessage : $message);
    }

}
