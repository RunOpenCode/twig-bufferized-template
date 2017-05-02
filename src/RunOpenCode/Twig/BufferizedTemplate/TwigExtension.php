<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate;

use RunOpenCode\Twig\BufferizedTemplate\Exception\InvalidArgumentException;
use RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize\Node;
use RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize\TokenParser;

/**
 * Class TwigExtension
 *
 * @package RunOpenCode\Twig\BufferizedTemplate
 */
class TwigExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    private $settings;

    public function __construct(array $settings = array())
    {
        $this->settings = array_merge(array(
            'nodes' => [],
            'whitelist' => [],
            'blacklist' => [],
            'default_execution_priority' => 0,
            'node_visitor_priority' => 10
        ), $settings);

        $this->settings['nodes'][Node::class] = null;

        $this->settings['nodes'] = call_user_func(function($nodes) {

            $processed = [];

            foreach ($nodes as $fqcn => $priority) {

                if (is_string($priority) && class_exists($priority)) {
                    $fqcn = $priority;
                    $priority = null;
                }

                $processed[$fqcn] = $priority;
            }

            return $processed;

        }, $this->settings['nodes']);

        if (count($this->settings['blacklist']) > 0 && count($this->settings['whitelist'])) {
            throw new InvalidArgumentException('You can use either black list or white list setting or non for bufferizing templates, but not both.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        return [
            new NodeVisitor($this->settings)
        ];
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
