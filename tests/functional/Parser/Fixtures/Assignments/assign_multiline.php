<?php declare(strict_types=1);
return [
    new \Helmich\TypoScriptParser\Parser\AST\Operator\Assignment(
        new \Helmich\TypoScriptParser\Parser\AST\ObjectPath('foo', 'foo'),
        new \Helmich\TypoScriptParser\Parser\AST\Scalar("    Hallo\n    Welt"),
        1
    ),
];