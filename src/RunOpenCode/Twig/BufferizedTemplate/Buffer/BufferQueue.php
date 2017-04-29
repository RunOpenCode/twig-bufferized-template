<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Buffer;

/**
 * Class BufferQueue
 *
 * Buffer queue contains list of buffered template portions sorted by execution priority.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Buffer
 */
final class BufferQueue implements \Countable, \Iterator
{
    /**
     * @var \SplPriorityQueue
     */
    private $queue;

    public function __construct()
    {
        $this->queue = new \SplPriorityQueue();
    }

    /**
     * Add template buffer to queue.
     *
     * @param TemplateBuffer $buffer
     *
     * @return BufferQueue $this
     */
    public function enqueue(TemplateBuffer $buffer)
    {
        $this->queue->insert($buffer, $buffer->getPriority());
        return $this;
    }

    /**
     * Clears queue
     *
     * @return BufferQueue $this
     */
    public function clear()
    {
        $this->queue = new \SplPriorityQueue();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->queue->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->queue->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->queue->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->queue->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->queue->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->queue->count();
    }
}
