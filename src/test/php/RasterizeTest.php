<?php
/**
 * Created by IntelliJ IDEA.
 * User: brandencash
 * Date: 6/19/15
 * Time: 10:57 AM
 */
namespace MashupMill\Batik;

use MashupMill\Batik\Command\Rasterize;

class RasterizeTest extends \PHPUnit_Framework_TestCase
{
    public function testRasterizeFile()
    {
        $output = tempnam(null, null);
        $cmd = new Rasterize(dirname(__DIR__) . '/resources/input.svg');
        $cmd->setOutput($output);
        if (!$cmd->exec()) {
            $this->fail($cmd->getStdOut());
        }
        $this->assertTrue(is_readable($output));
        $this->assertTrue(filesize($output) > 0);
    }

    public function testRasterizeData()
    {
        $input = file_get_contents(dirname(__DIR__) . '/resources/input.svg');
        $cmd = new Rasterize($input);
        if (!$cmd->exec()) {
            $this->fail($cmd->getStdOut());
        }
        $this->assertTrue(strlen($cmd->getOutput()) > 0);
    }
}
 