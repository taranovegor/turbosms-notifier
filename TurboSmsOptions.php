<?php
/**
 * This file is part of the turbosms-notifier application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace taranovegor\TurboSmsNotifier;

use Symfony\Component\Notifier\Exception\InvalidArgumentException;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;
use taranovegor\TurboSmsNotifier\MessageOptions\SmsMessageOptions;
use taranovegor\TurboSmsNotifier\MessageOptions\ViberMessageOptions;

/**
 * Class TurboSmsOptions
 */
final class TurboSmsOptions implements MessageOptionsInterface
{
    public const OPTION_START_TIME = 'start_time';
    public const OPTION_SMS = 'sms';
    public const OPTION_VIBER = 'viber';

    /**
     * @var array
     */
    private $options = [];

    /**
     * Date and time of delayed sending
     *
     * @param \DateTime $dateTime
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function startTime(\DateTime $dateTime): self
    {
        if ($dateTime < new \DateTime('-15 days')) {
            throw new InvalidArgumentException('It is permissible to indicate a date not exceeding 14 days from the current moment');
        }

        $this->options[self::OPTION_START_TIME] = $dateTime->format('Y-m-d H:i');

        return $this;
    }

    /**
     * @param SmsMessageOptions $smsOptions
     *
     * @return TurboSmsOptions
     */
    public function sms(SmsMessageOptions $smsOptions): TurboSmsOptions
    {
        $this->options[self::OPTION_SMS] = $smsOptions;

        return $this;
    }

    /**
     * @param ViberMessageOptions $viberOptions
     *
     * @return TurboSmsOptions
     */
    public function viber(ViberMessageOptions $viberOptions): TurboSmsOptions
    {
        $this->options[self::OPTION_VIBER] = $viberOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecipientId(): ?string
    {
        return null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->options;
    }
}
