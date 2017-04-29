<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Buffer;

use PHPUnit\Framework\TestCase;
use RunOpenCode\Twig\BufferizedTemplate\Buffer\TemplateBuffer;

/**
 * Class TemplateBufferTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Buffer
 */
class TemplateBufferTest extends TestCase
{
    /**
     * @test
     */
    public function itExecutesAndStoresExecutionResult()
    {
        $buffer = new TemplateBuffer(function() {
            echo 'buffer content';
        }, 10);

        $buffer->execute();

        $this->assertEquals('buffer content', $buffer->getOutput());
        $this->assertEquals(10, $buffer->getPriority());
    }

    /**
     * @test
     * @expectedException \RunOpenCode\Twig\BufferizedTemplate\Exception\LogicException
     */
    public function itThrowsExceptionIfBufferContentIsRequestedPriorToExecution()
    {
        $buffer = new TemplateBuffer(function() {
            return 'buffer content';
        });

        $buffer->getOutput();
    }
}
