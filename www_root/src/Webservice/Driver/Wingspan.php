<?php

namespace App\Webservice\Driver;

use Cake\Network\Http\Client;
use Muffin\Webservice\AbstractDriver;

class Wingspan extends AbstractDriver
{

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        $this->client(new Client([
            'host' => 'wingspan.kanly.org'
        ]));
    }
}
?>