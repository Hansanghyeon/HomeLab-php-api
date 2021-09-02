<?php
declare(strict_types=1);

namespace App\Application\Actions\Synology;

use App\Application\Actions\Synology\SynologyAction;
use Psr\Http\Message\ResponseInterface as Response;
use SynologySRM\SrmClient;

class ListDeviceAction extends SynologyAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $target = (string) $this->resolveArg('target');
        $this->logger->info("Wake On LAN.");
        return $this->respondWithData($this->wol($target));
    }

    public function wol($target)
    {
        $client = new SrmClient(
            $this->logger,
            getenv('SRM_USERNAME'),
            getenv('SRM_PASSWORD'),
            getenv('SRM_HOSTNAME'),
            getenv('SRM_PORT'),
            $https = true,
            true,
            $sid = null
        );

        if ($target === 'WINDOW-HYEON') {
            $client->addWakeOnLanDevice('18:c0:4d:a5:ac:2d');
            $result = $client->wakeOnLanDevice('18:c0:4d:a5:ac:2d');
            return $result;
        }
        return 'no tartget device';
    }
}
