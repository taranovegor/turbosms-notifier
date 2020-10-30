<?php


namespace taranovegor\TurboSmsNotifier\MessageOptions;

use Symfony\Component\Notifier\Exception\InvalidArgumentException;

/**
 * Class AbstractMessageOptions
 */
abstract class AbstractMessageOptions implements MessageOptionsInterface
{
    public const OPTION_SENDER = 'sender';
    public const OPTION_SUBJECT = 'text';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param string $sender
     *
     * @return $this
     */
    public function sender(string $sender): self
    {
        $this->options[self::OPTION_SENDER] = $sender;

        return $this;
    }

    /**
     * Override message subject
     *
     * @param string $subject
     *
     * @return $this
     */
    public function subject(string $subject): self
    {
        $this->options[self::OPTION_SUBJECT] = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->options;
    }
}
