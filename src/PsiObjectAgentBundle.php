<?php

namespace Psi\Bundle\ObjectAgent;

use Psi\Bundle\ObjectAgent\DependencyInjection\Compiler\ObjectAgentPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PsiObjectAgentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ObjectAgentPass());
    }
}
