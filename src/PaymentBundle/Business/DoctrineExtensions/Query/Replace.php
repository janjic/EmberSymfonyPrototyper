<?php
/**
 * Created by PhpStorm.
 * User: ugra
 * Date: 1/24/17
 * Time: 2:39 PM
 */

namespace PaymentBundle\Business\DoctrineExtensions\Query;


use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class Replace extends FunctionNode
{
    public $stringFirst;
    public $stringSecond;
    public $stringThird;


    public function getSql(SqlWalker $sqlWalker) {
        return  'REPLACE('.$this->stringFirst->dispatch($sqlWalker) .','
            . $this->stringSecond->dispatch($sqlWalker) . ','
            .$this->stringThird->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser) {

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->stringFirst = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->stringSecond = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->stringThird = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}