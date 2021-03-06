<?php

namespace NotificationChannels\Telegram;

class TelegramMessage
{
    /**
     * @var array Params payload.
     */
    public $payload = [];

    public $successFunction;
    public $failureFunction;
    /**
     * @var array Inline Keyboard Buttons.
     */
    protected $buttons = [];

    /**
     * @param string $content
     *
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
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
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content($content);
        $this->payload['parse_mode'] = 'Markdown';
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
     * Notification message (Supports Markdown).
     *
     * @param $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->payload['text'] = $content;

        return $this;
    }

    /**
     * Add an inline button.
     *
     * @param array $button Associative array of button metadata:
     *                      "text" - text of button,
     *                      "url" - url or "callback_data" - callback_data
     * @param int   $columns
     *
     * @return $this
     */
    public function button($button)
    {
        $this->buttons[] = $button;

        $replyMarkup['inline_keyboard'] = $this->buttons;
        $this->payload['reply_markup'] = json_encode($replyMarkup);

        return $this;
    }

    /**
     * Additional options to pass to sendMessage method.
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
