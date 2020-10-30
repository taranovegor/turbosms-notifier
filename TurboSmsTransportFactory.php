<?php
/**
 * This file is part of the turbosms-notifier application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace taranovegor\TurboSmsNotifier;

use Symfony\Component\Notifier\Exception\IncompleteDsnException;
use Symfony\Component\Notifier\Exception\UnsupportedSchemeException;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Transport\AbstractTransportFactory;
use Symfony\Component\Notifier\Transport\Dsn;
use Symfony\Component\Notifier\Transport\TransportFactoryInterface;
use Symfony\Component\Notifier\Transport\TransportInterface;

/**
 * Class TurboSmsTransportFactory
 */
final class TurboSmsTransportFactory extends AbstractTransportFactory
{
    public const SUPPORTED_SCHEME_TURBOSMS = 'turbosms';

    /**
     * @inheritDoc
     */
    public function create(Dsn $dsn): TransportInterface
    {
        // https://api.turbosms.ua/message/send.json

        $scheme = $dsn->getScheme();
        $authToken = $this->getUser($dsn);
        $sender = $dsn->getOption('sender');
        $host = 'default' === $dsn->getHost() ? null : $dsn->getHost();
        $port = $dsn->getPort();

//        if ('default' === $dsn->getHost()) {
//            $wsdl = 'http://turbosms.in.ua/api/wsdl.html';
//        } else {
//            $wsdl = sprintf(
//                'http://%s%s%s',
//                $dsn->getHost(),
//                $dsn->getPort() ? sprintf(':%s', $dsn->getPort()) : null,
//                $dsn->getPath()
//            );
//        }
//
        if (self::SUPPORTED_SCHEME_TURBOSMS === $scheme) {
            return (new TurboSmsTransport($authToken, $sender, $this->client, $this->dispatcher))
                ->setHost($host)
                ->setPort($port)
            ;
        }

        throw new UnsupportedSchemeException(
            $dsn,
            self::SUPPORTED_SCHEME_TURBOSMS,
            $this->getSupportedSchemes()
        );
    }

    /**
     * @inheritDoc
     */
    protected function getSupportedSchemes(): array
    {
        return [self::SUPPORTED_SCHEME_TURBOSMS];
    }
}
