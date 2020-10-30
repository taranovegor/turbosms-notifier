<?php


namespace taranovegor\TurboSmsNotifier\MessageOptions;

/**
 * Class TurboSmsViberOptions
 */
final class ViberMessageOptions extends AbstractMessageOptions
{
    public const OPTION_TTL = 'ttl';
    public const OPTION_IMAGE_URL = 'image_url';
    public const OPTION_CAPTION = 'caption';
    public const OPTION_ACTION = 'action';
    public const OPTION_COUNT_CLICKS = 'count_clicks';
    public const OPTION_TRANSACTIONAL = 'is_transactional';

    /**
     * Message lifetime in seconds during which it will be delivered
     *
     * @param int $ttl
     *
     * @return ViberMessageOptions
     */
    public function ttl(int $ttl): ViberMessageOptions
    {
        $this->options[self::OPTION_TTL] = $ttl;

        return $this;
    }

    /**
     * The URL of the image to be displayed in the message
     *
     * @param string $imageUrl
     *
     * @return ViberMessageOptions
     */
    public function imageUrl(string $imageUrl): ViberMessageOptions
    {
        $this->options[self::OPTION_IMAGE_URL] = $imageUrl;

        return $this;
    }

    /**
     * Text on a button in a message
     *
     * @param string $caption
     *
     * @return $this
     */
    public function caption(string $caption): ViberMessageOptions
    {
        $this->options[self::OPTION_CAPTION] = $caption;

        return $this;
    }

    /**
     * URL where the recipient of the message will go when clicking on the button
     *
     * @param string $action
     *
     * @return ViberMessageOptions
     */
    public function action(string $action): ViberMessageOptions
    {
        $this->options[self::OPTION_ACTION] = $action;

        return $this;
    }

    /**
     * Calculate conversion statistics
     *
     * @param bool $countClicks
     *
     * @return ViberMessageOptions
     */
    public function countClicks(bool $countClicks): ViberMessageOptions
    {
        $this->options[self::OPTION_COUNT_CLICKS] = $countClicks;

        return $this;
    }

    /**
     * Transaction message flag
     *
     * @param bool $transactional
     *
     * @return ViberMessageOptions
     */
    public function transactional(bool $transactional): ViberMessageOptions
    {
        $this->options[self::OPTION_TRANSACTIONAL] = $transactional;

        return $this;
    }
}
