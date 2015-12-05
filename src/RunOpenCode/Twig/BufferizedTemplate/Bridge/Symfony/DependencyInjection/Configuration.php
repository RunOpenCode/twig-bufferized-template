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
        $rootNode = $treeBuilder->root('run_open_code_twig_bufferized_template');

        $rootNode
            ->children()
                ->scalarNode('bufferManager')
                    ->info('Buffer manager that handles execution order of bufferized portions of Twig template.')
                    ->defaultValue('RunOpenCode\\Twig\\BufferizedTemplate\\Buffer\\BufferManager')
                    ->cannotBeEmpty()
                    ->end()
                ->integerNode('nodeVisitorPriority')
                    ->info('Twig node visitor priority - it should be highest, bufferization should be executed as latest as possible.')
                    ->defaultValue(10)
                    ->cannotBeEmpty()
                    ->end()
                ->integerNode('defaultExecutionPriority')
                    ->info('Default execution priority of bufferized node - if not explicitly provided.')
                    ->defaultValue(0)
                    ->cannotBeEmpty()
                    ->end()
                ->booleanNode('enabled')
                    ->info('Enable or disable template bufferization.')
                    ->defaultValue(true)
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
