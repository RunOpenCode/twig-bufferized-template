<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Twig;

use PHPUnit\Framework\TestCase;
use RunOpenCode\Twig\BufferizedTemplate\Tests\Mockup\DummyTwigNode;
use RunOpenCode\Twig\BufferizedTemplate\TwigExtension;
use RunOpenCode\Twig\BufferizedTemplate\Tests\Mockup\DummyTwigExtension;

class BufferizeTagTest extends TestCase
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var \Twig_Loader_Filesystem
     */
    protected $loader;

    public function setUp()
    {
        $this->loader = new \Twig_Loader_Filesystem(array(
            __DIR__.'/../Resources/twig'
        ));

        $this->environment = new \Twig_Environment($this->loader, []);

        $this->environment->addExtension(new TwigExtension([
            'nodes' => [
                DummyTwigNode::class => 20
            ]
        ]));
        $this->environment->addExtension(new DummyTwigExtension());
    }

    /**
     * @test
     */
    public function bufferizeTag()
    {
        $html = $this->environment->render('page.html.twig');
        $this->assertContains('Some var: 10', $html);
    }

    /**
     * @test
     */
    public function bufferizeTagWithNegativePriority()
    {
        $html = $this->environment->render('negative_priority.html.twig');
        $this->assertContains('Some var: 10', $html);
    }

    /**
     * @test
     * @expectedException \Twig_Error_Syntax
     */
    public function invalidBufferizationPriority()
    {
        $this->environment->render('invalid_priority.html.twig');
    }

    /**
     * @test
     */
    public function bufferizeCustomTag()
    {
        $html = $this->environment->render('bufferize_custom_tag.html.twig');
        $this->assertContains('Some var: 20', $html);
    }
}
