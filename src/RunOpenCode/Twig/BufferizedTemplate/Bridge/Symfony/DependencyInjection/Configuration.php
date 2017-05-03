<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection
 */
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
            ->fixXmlConfig('node')
            ->beforeNormalization()
                ->always()
                ->then(function ($value) {

                    if (isset($value['whitelist']) && is_string($value['whitelist'])) {
                        $value['whitelist'] = [$value['whitelist']];
                    }

                    if (isset($value['blacklist']) && is_string($value['blacklist'])) {
                        $value['blacklist'] = [$value['blacklist']];
                    }

                    if (isset($value['node'])) {

                        $value['node'] = array_map(function($node) {
                            if (!isset($node['value'])) {
                                $node['value'] = null;
                            }
                            return $node;
                        }, $value['node']);
                    }

                    return $value;
                })
            ->end()
            ->children()
                ->integerNode('node_visitor_priority')
                    ->info('Twig node visitor priority - it should be highest, bufferization should be executed as latest as possible.')
                    ->defaultValue(10)
                ->end()
                ->integerNode('default_execution_priority')
                    ->info('Default execution priority of bufferized node - if not explicitly provided.')
                    ->defaultValue(0)
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
                ->useAttributeAsKey('class')
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
