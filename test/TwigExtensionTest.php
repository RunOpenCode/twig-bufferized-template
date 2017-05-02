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
use RunOpenCode\Twig\BufferizedTemplate\NodeVisitor;
use RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize\TokenParser;
use RunOpenCode\Twig\BufferizedTemplate\TwigExtension;

class TwigExtensionTest extends TestCase
{
    /**
     * @test
     * @expectedException \RunOpenCode\Twig\BufferizedTemplate\Exception\InvalidArgumentException
     */
    public function itThrowsExceptionOnInvalidWhitelistAndBlacklist()
    {
        new TwigExtension([
            'whitelist' => ['template1'],
            'blacklist' => ['template2'],
        ]);
    }

    /**
     * @test
     */
    public function itProvidesNodeVisitor()
    {
        $extension = new TwigExtension();
        $this->assertCount(1, $extension->getNodeVisitors());
        $this->assertInstanceOf(NodeVisitor::class, $extension->getNodeVisitors()[0]);
    }

    /**
     * @test
     */
    public function itProvdesTokenParser()
    {
        $extension = new TwigExtension();
        $this->assertCount(1, $extension->getTokenParsers());
        $this->assertInstanceOf(TokenParser::class, $extension->getTokenParsers()[0]);
    }
}
