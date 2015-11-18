<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2015 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize;

/**
 * Class TokenParser
 *
 * Delay and bufferize portion of Twig template. Usage examples:
 *
 * {% bufferize %}
 *      ... content ...
 * {% endbufferize %}
 *
 * or
 *
 * {% bufferize 25 %}
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
        } elseif ($stream->test(\Twig_Token::OPERATOR_TYPE)) {
            $operator = $stream->next()->getValue();

            if (!in_array($operator, array('-', '+'))) {
                throw new \Twig_Error_Syntax(sprintf('Priority can be given as positive and/or negative number, operator "%s" is not allowed.', $operator));
            }

            $priority = $stream->expect(\Twig_Token::NUMBER_TYPE)->getValue();

            if ($operator == '-') {
                $priority = -$priority;
            }

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