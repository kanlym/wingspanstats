<?php

namespace App\Webservice;

use Cake\Network\Http\Client;
use Muffin\Webservice\Query;
use Muffin\Webservice\Webservice\Webservice;

class ArticlesWebservice extends Webservice
{

    /**
     * {@inheritDoc}
     */
    protected function _executeReadQuery(Query $query, array $options = [])
    {
        $d = date('Y-m');
        $response = $this->driver()->client()->get('/results/'.$d.'/agents.json');

        if (!$response->isOk()) {
            return false;
        }

        $resources = $this->_transformResults($query->endpoint(), $response->json['articles']);

        return new ResultSet($resources, count($resources));
    }
}
?>