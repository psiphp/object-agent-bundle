<?php

namespace Psi\Bundle\ObjectAgent\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

class ObjectAgentPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('psi_object_agent.agent_finder')) {
            return;
        }

        $taggedIds = $container->findTaggedServiceIds('psi_object_agent.agent');
        $registryDef = $container->getDefinition('psi_object_agent.agent_finder');
        $enabledAgents = $container->getParameter('psi_object_agent.enabled_agents');

        foreach ($taggedIds as $serviceId => $attributes) {
            $attributes = $attributes[0];
            if (!isset($attributes['alias'])) {
                throw new InvalidArgumentException(sprintf(
                    $this->context . ' "%s" has no "alias" attribute in its tag',
                    $serviceId
                ));
            }

            $alias = $attributes['alias'];

            $agents[$alias] = new Reference($serviceId);
        }

        if ($diff = array_diff($enabledAgents, array_keys($agents))) {
            throw new \RuntimeException(sprintf(
                'Unknown agent(s) "%s". Known agents: "%s"',
                implode('", "', $diff), implode('", "', array_keys($agents))
            ));
        }

        $agents = array_filter($agents, function ($key) use ($enabledAgents) {
            return in_array($key, $enabledAgents);
        }, ARRAY_FILTER_USE_KEY);

        $registryDef->replaceArgument(0, $agents);
    }
}
