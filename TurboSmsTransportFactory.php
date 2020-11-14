<?php
/**
 * This file is part of the turbosms-notifier application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace taranovegor\TurboSmsNotifier;

use Symfony\Component\Notifier\Exception\UnsupportedSchemeException;
use Symfony\Component\Notifier\Transport\AbstractTransportFactory;
use Symfony\Component\Notifier\Transport\Dsn;
use Symfony\Component\Notifier\Transport\TransportInterface;

/**
 * Class TurboSmsTransportFactory
 */
final class TurboSmsTransportFactory extends AbstractTransportFactory
{
    protected const SUPPORTED_SCHEME_TURBOSMS = 'turbosms';

    /**
     * @inheritDoc
     */
    public function create(Dsn $dsn): TransportInterface
    {
        $scheme = $dsn->getScheme();
        $authToken = $this->getUser($dsn);
        $sender = $dsn->getOption('sender');
        $sendVia = $dsn->getOption('send_via');
        $host = 'default' === $dsn->getHost() ? null : $dsn->getHost();
        $port = $dsn->getPort();

        if (self::SUPPORTED_SCHEME_TURBOSMS === $scheme) {
            return (new TurboSmsTransport($authToken, $sender, $sendVia, $this->client, $this->dispatcher))
                ->setHost($host)
                ->setPort($port)
            ;
        }

        throw new UnsupportedSchemeException($dsn, self::SUPPORTED_SCHEME_TURBOSMS, $this->getSupportedSchemes());
    }

    /**
     * @inheritDoc
     */
    protected function getSupportedSchemes(): array
    {
        return [self::SUPPORTED_SCHEME_TURBOSMS];
    }
}
