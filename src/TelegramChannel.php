<?php

namespace NotificationChannels\Telegram;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;

class TelegramChannel
{
    /**
     * @var Telegram
     */
    protected $telegram;

    /**
     * Channel constructor.
     *
     * @param Telegram $telegram
     */
    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTelegram($notifiable);

        if (is_string($message)) {
            $message = TelegramMessage::create($message);
        }
        if ($message->toNotGiven()) {
            if (!$to = $notifiable->routeNotificationFor('telegram')) {
                throw CouldNotSendNotification::chatIdNotProvided();
            }

            $message->to($to);
        }

        if(isset($message->payload['text']) && $message->payload['text'])
        {
            $params = $message->toArray();
            $response = $this->telegram->sendMessage($params);
        }
        elseif (isset($message->payload['latitude']) && isset($message->payload['longitude'])) {
            $params = $message->toArray();
            $response = $this->telegram->sendLocation($params);
        }
        else
        {
            if(isset($message->payload['file']))
            {
                $params = $message->toMultipart();
                $response = $this->telegram->sendFile($params, $message->type, true);
            }
            else
            {
                $params = $message->toArray();
                $response = $this->telegram->sendFile($params, $message->type);
            }
        }
        if($response){
            $message->success(json_decode($response->getBody()->getContents()));
        }
    }
}
<?php

namespace NotificationChannels\Telegram;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;

class TelegramChannel
{
    /**
     * @var Telegram
     */
    protected $telegram;

    /**
     * Channel constructor.
     *
     * @param Telegram $telegram
     */
    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTelegram($notifiable);

        if (is_string($message)) {
            $message = TelegramMessage::create($message);
        }
        if ($message->toNotGiven()) {
            if (!$to = $notifiable->routeNotificationFor('telegram')) {
                throw CouldNotSendNotification::chatIdNotProvided();
            }

            $message->to($to);
        }

        if(isset($message->payload['text']) && $message->payload['text'])
        {
            $params = $message->toArray();
            $response = $this->telegram->sendMessage($params);
        }
        elseif (isset($message->payload['latitude']) && isset($message->payload['longitude'])) {
            $params = $message->toArray();
            $response = $this->telegram->sendLocation($params);
        }
        else
        {
            if(isset($message->payload['file']))
            {
                $params = $message->toMultipart();
                $response = $this->telegram->sendFile($params, $message->type, true);
            }
            else
            {
                $params = $message->toArray();
                $response = $this->telegram->sendFile($params, $message->type);
            }
        }
        if($response){
            $message->success(json_decode($response->getBody()->getContents()));
        }
    }
}
