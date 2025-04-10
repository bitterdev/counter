<?php

namespace Bitter\Counter\Routing;

use Bitter\Counter\API\V1\Middleware\FractalNegotiatorMiddleware;
use Bitter\Counter\API\V1\Configurator;
use Concrete\Core\Routing\RouteListInterface;
use Concrete\Core\Routing\Router;

class RouteList implements RouteListInterface
{
    public function loadRoutes(Router $router)
    {
        $router
            ->buildGroup()
            ->setNamespace('Concrete\Package\Counter\Controller\Dialog\Support')
            ->setPrefix('/ccm/system/dialogs/counter')
            ->routes('dialogs/support.php', 'counter');
    }
}