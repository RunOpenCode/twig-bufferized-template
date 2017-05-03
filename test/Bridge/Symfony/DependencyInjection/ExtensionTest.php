<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Bridge\SymfonyDependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection\Extension;

/**
 * Class ExtensionTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Bridge\SymfonyDependencyInjection
 */
class ExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function itLoadsAndConfiguresTwigExtension()
    {
        $configuration = [
            'node_visitor_priority' => -5,
            'default_execution_priority' => -5,
            'whitelist' => [ 'template-to-bufferize.html.twig' ],
            'blacklist' => [ 'template-not-to-bufferize.html.twig', 'additional-template-not-to-bufferize.html.twig' ],
            'nodes' => [
                'My\Node\Class' => null,
                'My\Other\Node\Class' => 17,
            ],
        ];

        $this->load($configuration);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument('runopencode.twig.bufferized_template', 0, $configuration);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return array(
            new Extension()
        );
    }
}
