<?php

namespace Psi\Bundle\ObjectAgent\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('psi_object_agent');
        $rootNode->addDefaultsIfNotSet();
        $rootNode->children()
            ->arrayNode('enabled_agents')
                ->prototype('scalar')->end()
            ->end();

        return $treeBuilder;
    }
}
