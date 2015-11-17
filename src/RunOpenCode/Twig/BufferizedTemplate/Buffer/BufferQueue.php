<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Buffer;

/**
 * Class BufferQueue
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

    public function enqueue(TemplateBuffer $buffer)
    {
        $this->queue->insert($buffer, $buffer->getPriority());
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