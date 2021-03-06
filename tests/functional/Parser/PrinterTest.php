<?php declare(strict_types=1);
namespace Helmich\TypoScriptParser\Tests\Functional\Parser;

use Helmich\TypoScriptParser\Parser\Printer\ASTPrinterInterface;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

class PrinterTest extends TestCase
{
    /** @var ASTPrinterInterface */
    private $printer;

    public function setUp(): void
    {
        $this->printer = new PrettyPrinter();
    }

    public function dataForPrinterTest()
    {
        $files = glob(__DIR__ . '/Fixtures/*/*.typoscript');
        foreach ($files as $outputFile) {
            $astFile = str_replace('.typoscript', '.php', $outputFile);
            /** @noinspection PhpIncludeInspection */
            $ast = include $astFile;

            $exceptionFile = $outputFile . '.print';
            if (file_exists($exceptionFile)) {
                $outputFile = $exceptionFile;
            }

            $output = file_get_contents($outputFile);
            $output = implode("\n", array_filter(explode("\n", $output)));

            yield [$ast, $output];
        }
    }

    /**
     * @dataProvider dataForPrinterTest
     * @param $ast
     * @param $expectedOutput
     */
    public function testParsedCodeIsCorrectlyPrinted($ast, $expectedOutput)
    {
        $output = new BufferedOutput();
        $this->printer->printStatements($ast, $output);

        $this->assertEquals(trim($expectedOutput), trim($output->fetch()));
    }
}