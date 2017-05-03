<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag\Bufferize;

use RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize\Node;
use RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag\BaseNodeTest;

/**
 * Class NodeTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag\Bufferize
 */
class NodeTest extends BaseNodeTest
{
    /**
     * @test
     */
    public function itCompiles()
    {
        $node = new Node(['body' => new \Twig_Node_Text('A text', 0)]);

        $compiler = $this->getCompiler();
        $compiler->compile($node);

        $source = $compiler->getSource();

        $expected = <<<EOF

echo "A text";

EOF;

        $this->assertEquals($expected, $source);
    }
}
