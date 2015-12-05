<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2015 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Mockup;

class DummyTwigTokenParser extends \Twig_TokenParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideDummyTagEnd'), true);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new DummyTwigNode(array('body' => $body), array(), $lineno, $this->getTag());
    }

    public function decideDummyTagEnd(\Twig_Token $token)
    {
        return $token->test('end_dummy_tag');
    }


    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'dummy_tag';
    }
}
