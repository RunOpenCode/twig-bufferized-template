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
use RunOpenCode\Twig\BufferizedTemplate\Buffer\BufferQueue;
use RunOpenCode\Twig\BufferizedTemplate\Buffer\TemplateBuffer;

/**
 * Class BufferQueueTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Buffer
 *
 * @internal
 */
class BufferQueueTest extends TestCase
{
    /**
     * @test
     */
    public function itEnqueuesElementsByPriority()
    {
        $queue = new BufferQueue();

        $queue->enqueue(new TemplateBuffer(function() { echo '10'; }, 10));
        $queue->enqueue(new TemplateBuffer(function() { echo '6'; }, 6));
        $queue->enqueue(new TemplateBuffer(function() { echo '20'; }, 20));
        $queue->enqueue(new TemplateBuffer(function() { echo '17'; }, 17));
        $queue->enqueue(new TemplateBuffer(function() { echo '3'; }, 3));

        $this->assertEquals(5, $queue->count());

        $output = [];

        /**
         * @var TemplateBuffer $buffer
         */
        foreach ($queue as $key => $buffer) {
            $output[] = (int) $buffer->execute()->getOutput();
        }

        $this->assertEquals([ 20, 17, 10, 6, 3 ], $output);

        $queue->clear();

        $this->assertEquals(0, $queue->count());
    }
}
