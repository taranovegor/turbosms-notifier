<?php
/**
 * This file is part of the turbosms-notifier application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace taranovegor\TurboSmsNotifier;

use Symfony\Component\Notifier\Exception\LogicException;
use Symfony\Component\Notifier\Exception\TransportException;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Transport\AbstractTransport;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use taranovegor\TurboSmsNotifier\MessageOptions\SmsMessageOptions;
use taranovegor\TurboSmsNotifier\MessageOptions\ViberMessageOptions;

/**
 * Class TurboSmsTransport
 */
final class TurboSmsTransport extends AbstractTransport implements \Stringable
{
    protected const HOST = 'api.turbosms.ua';

    /**
     * @var string
     */
    private $authToken;

    /**
     * @var string
     */
    private $sender;

    /**
     * TurboSmsTransport constructor.
     *
     * @param string                        $authToken
     * @param string                        $sender
     * @param HttpClientInterface|null      $client
     * @param EventDispatcherInterface|null $dispatcher
     */
    public function __construct(string $authToken, string $sender, HttpClientInterface $client = null, EventDispatcherInterface $dispatcher = null)
    {
        parent::__construct($client, $dispatcher);

        $this->authToken = $authToken;
        $this->sender = $sender;
    }

    /**
     * @param MessageInterface $message
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function doSend(MessageInterface $message): void
    {
        if (!$message instanceof TurboSms) {
            throw new LogicException(sprintf('The "%s" transport only supports instances of "%s" (instance of "%s" given).', __CLASS__, TurboSms::class, get_debug_type($message)));
        }

        $options = $message->getOptions() ? $message->getOptions()->toArray() : [];

        $smsOptions = &$options[TurboSmsOptions::OPTION_SMS];
        if (isset($smsOptions) && !isset($smsOptions[SmsMessageOptions::OPTION_SENDER])) {
            $smsOptions[SmsMessageOptions::OPTION_SENDER] = $this->sender;
        }

        $viberOptions = &$options[TurboSmsOptions::OPTION_VIBER];
        if (isset($viberOptions) && !isset($viberOptions[ViberMessageOptions::OPTION_SENDER])) {
            $viberOptions[ViberMessageOptions::OPTION_SENDER] = $this->sender;
        }
        
        $response = $this->client->request('POST', sprintf('https://%s/message/send.json', $this->getEndpoint()), [
            'auth_bearer' => $this->authToken,
            'json' => array_filter($options),
        ]);

        if (200 !== $response->getStatusCode()) {
            throw new TransportException(sprintf('Unable to post the TurboSMS message: "%s".', $response->getContent(false)), $response);
        }
    }

    /**
     * @param MessageInterface $message
     *
     * @return bool
     */
    public function supports(MessageInterface $message): bool
    {
        return $message instanceof TurboSms;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf(
            '%s://%s?sender=%s',
            TurboSmsTransportFactory::SUPPORTED_SCHEME_TURBOSMS,
            $this->getEndpoint(),
            urlencode($this->sender)
        );
    }
}
