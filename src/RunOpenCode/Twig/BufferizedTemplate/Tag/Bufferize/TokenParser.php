<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize;

/**
 * Class TokenParser
 *
 * Delay and bufferize portion of Twig template.
 *
 * {% bufferize %}
 *      ... content ...
 * {% endbufferize %}
 *
 * or
 *
 * {% bufferize [int: execution priority] %}
 *      ... content ...
 * {% endbufferize %}
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize
 */
class TokenParser extends \Twig_TokenParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        if ($stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            $priority = null;
        } else {
            $priority = $stream->expect(\Twig_Token::NUMBER_TYPE)->getValue();
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideBufferizeEnd'), true);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new Node(array('body' => $body), array('priority' => $priority), $lineno, $this->getTag());
    }

    public function decideBufferizeEnd(\Twig_Token $token)
    {
        return $token->test('endbufferize');
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'bufferize';
    }
}