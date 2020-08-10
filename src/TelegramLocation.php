<?php

namespace NotificationChannels\Telegram;

class TelegramLocation
{
    /**
     * @var array Params payload.
     */
    public $payload = [];
    public $successFunction;
    public $failureFunction;
    /**
     * @param null $latitude
     * @param null $longitude
     *
     * @return static
     */
    public static function create($latitude = null, $longitude = null)
    {
        return new static($latitude, $longitude);
    }

    public function onSuccess($function)
    {
        $this->successFunction = $function;

        return $this;
    }

    public function success($response){
        if ($this->successFunction instanceof \Closure)
            call_user_func($this->successFunction, $response);
    }
    
    public function onFailure($function)
    {
        $this->failureFunction = $function;

        return $this;
    }

    public function failure($response){
        if ($this->failureFunction instanceof \Closure)
            call_user_func($this->failureFunction, $response);
    }


    /**
     * Message constructor.
     *
     * @param null $latitude
     * @param null $longitude
     */
    public function __construct($latitude = null, $longitude = null)
    {
        $this->latitude($latitude);
        $this->longitude($longitude);
    }

    /**
     * Recipient's Chat ID.
     *
     * @param $chatId
     *
     * @return $this
     */
    public function to($chatId)
    {
        $this->payload['chat_id'] = $chatId;

        return $this;
    }

    /**
     * Location's latitude.
     *
     * @param $latitude
     *
     * @return TelegramLocation
     */
    public function latitude($latitude)
    {
        $this->payload['latitude'] = $latitude;

        return $this;
    }

    /**
     * Location's latitude.
     *
     * @param $longitude
     *
     * @return TelegramLocation
     */
    public function longitude($longitude)
    {
        $this->payload['longitude'] = $longitude;

        return $this;
    }

    /**
     * Additional options to pass to sendLocation method.
     *
     * @param array $options
     *
     * @return $this
     */
    public function options(array $options)
    {
        $this->payload = array_merge($this->payload, $options);

        return $this;
    }

    /**
     * Determine if chat id is not given.
     *
     * @return bool
     */
    public function toNotGiven()
    {
        return !isset($this->payload['chat_id']);
    }

    /**
     * Returns params payload.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->payload;
    }
}
