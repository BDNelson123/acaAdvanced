<?php

namespace ACAApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use ACAApiBundle\DependencyInjection\Security\Factory\WsseFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ACAApiBundle extends Bundle
{
    // Part of WSSE implementation
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WsseFactory());
    }
}
