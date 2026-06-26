<?php

namespace NotificationChannels\Telegram;

class TelegramRichMessageObject implements \JsonSerializable
{

    public function __construct(
        private ?string $html = null,
        private ?string $markdown = null,
        private bool $is_rtl = false,
        private bool $skip_entity_detection = false
    )
    {
    }

    public static function create(
        ?string $html = null,
        ?string $markdown = null,
        bool $is_rtl = false,
        bool $skip_entity_detection = false
    )
    {
        return new static($html, $markdown, $is_rtl, $skip_entity_detection);
    }

    public function html($html)
    {
        $this->html = $html;

        return $this;
    }

    public function markdown($markdown)
    {
        $this->markdown = $markdown;

        return $this;
    }

    public function isRtl($isRtl = true)
    {
        $this->is_rtl = $isRtl;

        return $this;
    }

    public function skipEntityDetection($skipEntityDetection = true)
    {
        $this->skip_entity_detection = $skipEntityDetection;

        return $this;
    }

    public function toArray()
    {
        $payload = [
            'is_rtl' => $this->is_rtl,
            'skip_entity_detection' => $this->skip_entity_detection,
        ];
        if($this->html){
            $payload['html'] = $this->html;
        } elseif($this->markdown){
            $payload['markdown'] = $this->markdown;
        }
        return $payload;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
