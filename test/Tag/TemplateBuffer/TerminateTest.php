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

use RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer\Terminate;
use RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag\BaseNodeTest;

/**
 * Class TerminateTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag\TemplateBuffer
 */
class TerminateTest extends BaseNodeTest
{
    /**
     * @test
     */
    public function itCompiles()
    {
        $node = new Terminate([], ['bufferized_context_variable_name' => '$_bufferized_context_variable_name', 'execution_priority' => 20]);

        $compiler = $this->getCompiler();
        $compiler->compile($node);

        $source = $compiler->getSource();

        $expected = <<<EOF
}, \$this), 20);
{{ bufferize_variable }}->display();

EOF;

        $this->assertEquals(str_replace('{{ bufferize_variable }}', $node->getAttribute('bufferized_context_variable_name'), $expected), $source);
    }
}
