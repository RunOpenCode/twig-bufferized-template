<?php

namespace RunOpenCode\Twig\BufferizedTemplate;

use RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize\TokenParser;

class Extension extends \Twig_Extension
{
    const NAME = 'bufferized_template_extension';

    /**
     * @var array
     */
    private $settings;

    public function __construct(array $settings = array())
    {
        $this->settings = array_merge(array(
            'enabled' => true,
            'nodes' => array(),
            'functions' => array(),
            'whitelist' => array(),
            'blacklist' => array(),
            'bufferManager' => 'RunOpenCode\\Twig\\BufferizedTemplate\\Buffer\\BufferManager',
            'defaultExecutionPriority' => 0,
            'nodeVisitorPriority' => 10
        ), $settings);

        $this->settings['nodes']['RunOpenCode\\Twig\\BufferizedTemplate\\Tag\\Bufferize\\Node'] = 0;

        if (count($this->settings['blacklist']) > 0 && count($this->settings['whitelist'])) {
            throw new \InvalidArgumentException('You can use either black list or white list setting or non for bufferizing templates, but not both.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        if ($this->settings['enabled']) {

            return array(
                new NodeVisitor($this->settings)
            );
        } else {
            return array();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array(
            new TokenParser()
        );
    }

    public function createBuffer()
    {
        return new $this->settings['bufferManager']();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}