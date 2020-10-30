<?php


namespace taranovegor\TurboSmsNotifier\MessageOptions;

/**
 * Class SmsMessageOptions
 */
final class SmsMessageOptions extends AbstractMessageOptions
{
    const OPTION_FLASH = 'is_flash';

    /**
     * @param bool $flash
     *
     * @return SmsMessageOptions
     */
    public function flash(bool $flash): SmsMessageOptions
    {
        $this->options[self::OPTION_FLASH] = $flash;

        return $this;
    }
}
