<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;
use Dwo\Flagging\Walker;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * @author David Wolter <david@lovoo.com>
 */
class ExpressionVoter implements VoterInterface
{
    /**
     * @var ExpressionLanguage
     */
    protected $language;

    /**
     * @param ExpressionLanguage|null $language
     */
    public function __construct(ExpressionLanguage $language = null)
    {
        if (null !== $language) {
            $this->language = $language;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        return Walker::walkOr(
            $config,
            function ($expression) use ($context) {
                return $this->getExpressionLanguage()->evaluate($expression, $context->getParams());
            }
        );
    }

    /**
     * @return ExpressionLanguage
     */
    protected function getExpressionLanguage()
    {
        if (null === $this->language) {
            $this->language = new ExpressionLanguage();

            foreach ($this->getMethods() as $name => $closures) {
                $this->language->register($name, $closures[0], $closures[1]);
            }
        }

        return $this->language;
    }

    /**
     * @return array
     */
    protected function getMethods()
    {
        return array(
            'in_array'   => array(
                function ($needle, $haystack) {
                    return sprintf('in_array(%s, %s)', $needle, $haystack);
                },
                function (array $variables, $needle, $haystack) {
                    return in_array($needle, $haystack);
                }
            ),
            'strtolower' => array(
                function ($string) {
                    return sprintf('strtolower(%s)', $string);
                },
                function (array $variables, $string) {
                    return strtolower($string);
                }
            ),
            'empty'      => array(
                function ($str) {
                    return sprintf('empty(%s)', $str);
                },
                function (array $variables, $str) {
                    return empty($str);
                }
            ),
            'count'      => array(
                function ($array) {
                    return sprintf('count(%s)', $array);
                },
                function (array $variables, $array) {
                    return count($array);
                }
            ),
            'preg_match' => array(
                function ($pattern, $subject) {
                    return sprintf('preg_match(%s, %s)', $pattern, $subject);
                },
                function (array $variables, $pattern, $subject) {
                    return preg_match($pattern, $subject) >= 1;
                }
            )
        );
    }
}