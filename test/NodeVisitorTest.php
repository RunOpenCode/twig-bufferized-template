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
use RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize\Node;
use RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer\BreakPoint;
use RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer\Initialize;
use RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer\Terminate;
use RunOpenCode\Twig\BufferizedTemplate\Tests\Fixtures\Mockup\DummyTwigExtension;
use RunOpenCode\Twig\BufferizedTemplate\Tests\Fixtures\Mockup\DummyTwigNode;
use RunOpenCode\Twig\BufferizedTemplate\TwigExtension;

/**
 * Class NodeVisitorTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Twig
 */
class NodeVisitorTest extends TestCase
{
    /**
     * @test
     */
    public function itBufferizesNodes()
    {
        $env = new \Twig_Environment($this->getMockBuilder(\Twig_LoaderInterface::class)->getMock(), ['cache' => false, 'autoescape' => false]);
        $env
            ->addExtension(new TwigExtension());

        $stream = $env->parse($env->tokenize(new \Twig_Source('{% bufferize 10 %}Content{% endbufferize %}', 'page')));
        $node = $stream->getNode('body');

        $this->assertInstanceOf(Initialize::class, $node->getNode(0));
        $this->assertInstanceOf(\Twig_Node_Body::class, $body = $node->getNode(1));

        $body = $body->getNode(0);

        $this->assertInstanceOf(BreakPoint::class, $defaultPriorityNode = $body->getNode(0));
        $this->assertEquals(0, $defaultPriorityNode->getAttribute('execution_priority'));
        $this->assertInstanceOf(Node::class, $body->getNode(1));
        $this->assertInstanceOf(BreakPoint::class, $priorityNode = $body->getNode(2));
        $this->assertEquals(10, $priorityNode->getAttribute('execution_priority'));

        $this->assertInstanceOf(Terminate::class, $node->getNode(2));
    }

    /**
     * @test
     */
    public function itBufferizesCustomConfiguredTags()
    {
        $env = new \Twig_Environment($this->getMockBuilder(\Twig_LoaderInterface::class)->getMock(), ['cache' => false, 'autoescape' => false]);
        $env->addExtension(new DummyTwigExtension());
        $env->addExtension(new TwigExtension([
            'default_execution_priority' => 20,
            'nodes' => [
                DummyTwigNode::class => 5
            ]
        ]));

        $stream = $env->parse($env->tokenize(new \Twig_Source('{% dummy_tag %}Content{% end_dummy_tag %}', 'page')));
        $priority = $stream->getNode('body')->getNode(1)->getNode(0)->getNode(2)->getAttribute('execution_priority');

        $this->assertEquals(5, $priority);
    }

    /**
     * @test
     */
    public function itBufferizesCustomConfiguredTagsWithDefaultPriority()
    {
        $env = new \Twig_Environment($this->getMockBuilder(\Twig_LoaderInterface::class)->getMock(), ['cache' => false, 'autoescape' => false]);
        $env->addExtension(new DummyTwigExtension());
        $env->addExtension(new TwigExtension([
            'default_execution_priority' => 20,
            'nodes' => [ DummyTwigNode::class ]
        ]));

        $stream = $env->parse($env->tokenize(new \Twig_Source('{% dummy_tag %}Content{% end_dummy_tag %}', 'page')));
        $priority = $stream->getNode('body')->getNode(1)->getNode(0)->getNode(2)->getAttribute('execution_priority');

        $this->assertEquals(20, $priority);
    }

    /**
     * @test
     */
    public function itSkipsBlacklisted()
    {
        $env = new \Twig_Environment($this->getMockBuilder(\Twig_LoaderInterface::class)->getMock(), ['cache' => false, 'autoescape' => false]);
        $env
            ->addExtension(new TwigExtension([
                'blacklist' => ['page']
            ]));

        $stream = $env->parse($env->tokenize(new \Twig_Source('{% bufferize 10 %}Content{% endbufferize %}', 'page')));
        $node = $stream->getNode('body');

        $this->assertInstanceOf(Node::class, $node->getNode(0));
    }

    /**
     * @test
     */
    public function itIncludesOnlyWhitelisted()
    {
        $env = new \Twig_Environment($this->getMockBuilder(\Twig_LoaderInterface::class)->getMock(), ['cache' => false, 'autoescape' => false]);
        $env
            ->addExtension(new TwigExtension([
                'whitelist' => ['other_page']
            ]));

        $stream = $env->parse($env->tokenize(new \Twig_Source('{% bufferize %}Content{% endbufferize %}', 'page')));
        $node = $stream->getNode('body');

        $this->assertInstanceOf(Node::class, $node->getNode(0));
    }
}
