<?php
/**
 * This file is part of the turbosms-notifier application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace taranovegor\TurboSmsNotifier;

use Symfony\Component\Notifier\Exception\LogicException;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Notification\SmsNotificationInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;

/**
 * Class TurboSms
 */
final class TurboSms implements MessageInterface, SmsRecipientInterface, SmsNotificationInterface
{
    /**
     * @var string
     */
    private $phone;

    /**
     * @var string|null
     */
    private $subject;

    /**
     * @var TurboSmsOptions|null
     */
    private $options;

    /**
     * TurboSms constructor.
     *
     * @param string               $phone
     * @param string               $subject
     * @param TurboSmsOptions|null $options
     */
    public function __construct(string $phone, string $subject, TurboSmsOptions $options = null)
    {
        $this->phone = $phone;
        $this->subject = $subject;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getRecipientId(): string
    {
        return $this->getPhone();
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return MessageOptionsInterface|null
     */
    public function getOptions(): ?MessageOptionsInterface
    {
        return $this->options;
    }

    /**
     * @return string|null
     */
    public function getTransport(): ?string
    {
        return null;
    }

    /**
     * @param string $phone
     *
     * @return SmsRecipientInterface
     */
    public function phone(string $phone): SmsRecipientInterface
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param Recipient   $recipient
     * @param string|null $transport
     *
     * @return SmsMessage|null
     */
    public function asSmsMessage(Recipient $recipient, string $transport = null): ?SmsMessage
    {
        if (!$recipient instanceof SmsRecipientInterface) {
            throw new LogicException(sprintf('To send a SMS message, recipient should implement "%s".', SmsRecipientInterface::class));
        }

        return new SmsMessage($recipient->getPhone(), $this->getSubject());
    }
}
