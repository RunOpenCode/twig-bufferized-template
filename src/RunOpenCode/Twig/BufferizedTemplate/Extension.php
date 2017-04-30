<?php

namespace RunOpenCode\Twig\BufferizedTemplate;

use RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize\TokenParser;

class Extension extends \Twig_Extension
{
    /**
     * @var array
     */
    private $settings;

    public function __construct(array $settings = array())
    {
        $this->settings = array_merge(array(
            'enabled' => true,
            'nodes' => [],
            'whitelist' => [],
            'blacklist' => [],
            'default_execution_priority' => 0,
            'node_visitor_priority' => 10
        ), $settings);

        $this->settings['nodes']['RunOpenCode\\Twig\\BufferizedTemplate\\Tag\\Bufferize\\Node'] = $this->settings['default_execution_priority'];

        if (count($this->settings['blacklist']) > 0 && count($this->settings['whitelist'])) {
            throw new \InvalidArgumentException('You can use either black list or white list setting or non for bufferizing templates, but not both.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        return $this->settings['enabled'] ? [ new NodeVisitor($this->settings) ] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return [
            new TokenParser()
        ];
    }
}
