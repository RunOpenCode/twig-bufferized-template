<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag\TemplateBuffer;

use RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer\BreakPoint;
use RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag\BaseNodeTest;

/**
 * Class BreakPointTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag\TemplateBuffer
 */
class BreakPointTest extends BaseNodeTest
{
    /**
     * @test
     */
    public function itCompiles()
    {
        $node = new BreakPoint([], ['execution_priority' => 20, 'bufferized_context_variable_name' => '$_bufferized_context_variable_name']);

        $compiler = $this->getCompiler();
        $compiler->compile($node);

        $source = $compiler->getSource();

        $expected = <<<EOF
}, \$this), 20);
{{ bufferize_variable }}->bufferize(Closure::bind(function() use (&\$context, &\$blocks) { 

EOF;

        $this->assertEquals(str_replace('{{ bufferize_variable }}', $node->getAttribute('bufferized_context_variable_name'), $expected), $source);
    }
}
