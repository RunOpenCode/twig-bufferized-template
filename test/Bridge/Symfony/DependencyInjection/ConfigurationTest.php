<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bridge\Symfony\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection\Configuration;
use RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection\Extension;

/**
 * Class ConfigurationTest
 *
 * @package Bridge\Symfony\DependencyInjection
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    /**
     * @test
     */
    public function itHasReasonableDefaults()
    {
        $this->assertProcessedConfigurationEquals([
            'node_visitor_priority' => 10,
            'default_execution_priority' => 0,
            'whitelist' => [],
            'blacklist' => [],
            'nodes' => [],
        ], [
            __DIR__ . '/../Fixtures/Resources/config/empty.xml'
        ]);
    }

    /**
     * @test
     */
    public function itCanBeFullyConfigured()
    {
        $this->assertProcessedConfigurationEquals([
            'node_visitor_priority' => -5,
            'default_execution_priority' => -5,
            'whitelist' => [ 'template-to-bufferize.html.twig' ],
            'blacklist' => [ 'template-not-to-bufferize.html.twig', 'additional-template-not-to-bufferize.html.twig' ],
            'nodes' => [
                'My\Node\Class' => null,
                'My\Other\Node\Class' => 17,
            ],
        ], [
            __DIR__ . '/../Fixtures/Resources/config/full.xml'
        ]);
    }

    /**
     * @test
     */
    public function itCanBeFullyConfiguredViaYaml()
    {
        $this->assertProcessedConfigurationEquals([
            'node_visitor_priority' => -5,
            'default_execution_priority' => -5,
            'whitelist' => [ 'template-to-bufferize.html.twig' ],
            'blacklist' => [ 'template-not-to-bufferize.html.twig', 'additional-template-not-to-bufferize.html.twig' ],
            'nodes' => [
                'My\Node\Class' => null,
                'My\Other\Node\Class' => 17,
            ],
        ], [
            __DIR__ . '/../Fixtures/Resources/config/full.yml'
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtension()
    {
        return new Extension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
