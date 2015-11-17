<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Buffer;

final class BufferManager
{
    /**
     * @var BufferQueue
     */
    private $executionQueue;

    /**
     * @var array
     */
    private $renderingQueue;

    /**
     * @var string
     */
    private $output;

    public function __construct()
    {
        $this->executionQueue = new BufferQueue();
        $this->renderingQueue = array();
        $this->output = null;
    }

    public function bufferize(callable $callable, $priority = 0)
    {
        $templateBuffer = new TemplateBuffer($callable, $priority);

        $this->executionQueue->enqueue($templateBuffer);
        $this->renderingQueue[] = $templateBuffer;
    }

    public function append($html)
    {
        $this->renderingQueue[] = $html;
    }

    public function render()
    {
        return $this->getOutput();
    }

    public function display()
    {
        echo $this->getOutput();
    }

    private function getOutput()
    {
        if (is_null($this->output)) {
            $this->output = '';

            /**
             * @var TemplateBuffer $templateBuffer
             */
            foreach ($templateBuffers = $this->executionQueue as $templateBuffer) {
                $templateBuffer->execute();
            }

            foreach ($templateBuffers = $this->renderingQueue as $renderer) {
                $this->output .= (($renderer instanceof TemplateBuffer) ? $renderer->getOutput() : $renderer);
            }
        }

        return $this->output;
    }
}