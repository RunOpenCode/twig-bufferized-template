<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection;

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
        $rootNode = $treeBuilder->root('runopencode_twig_bufferized_template');

        $rootNode
            ->children()
                ->integerNode('node_visitor_priority')
                    ->info('Twig node visitor priority - it should be highest, bufferization should be executed as latest as possible.')
                    ->defaultValue(10)
                    ->cannotBeEmpty()
                ->end()
                ->integerNode('default_execution_priority')
                    ->info('Default execution priority of bufferized node - if not explicitly provided.')
                    ->defaultValue(0)
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('whitelist')
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->arrayNode('blacklist')
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->arrayNode('nodes')
                ->useAttributeAsKey('name')
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
