<?php
/**
 * Created by IntelliJ IDEA.
 * User: brandencash
 * Date: 6/19/15
 * Time: 10:16 AM
 */
namespace MashupMill\Batik\Command;

use InvalidArgumentException;

class Rasterize extends AbstractCommand
{
    protected $jarName = 'batik-rasterizer';

    /** @var string */
    protected $input;

    /** @var string */
    protected $inputData;

    protected $isData = false;

    function __construct($input = null)
    {
        $isData = strtolower(substr(trim($input), 0, 5)) === '<?xml';
        if ($isData) {
            $this->setInputData($input);
        } else {
            $this->setInput($input);
        }
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param string $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

    /**
     * @return string
     */
    public function getInputData()
    {
        return $this->inputData;
    }

    /**
     * @param string $inputData
     */
    public function setInputData($inputData)
    {
        $this->inputData = $inputData;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->getOption('d');
    }

    /**
     * @param string $output
     */
    public function setOutput($output)
    {
        $this->setOption('d', $output);
    }

    /**
     * @return string
     */
    public function readOutput()
    {
        return is_readable($this->getOutput()) ? file_get_contents($this->getOutput()) : $this->getOutput();
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function getArguments()
    {
        if ($this->getInput() === null) {
            throw new InvalidArgumentException("input file(s) must be provided");
        }

        $args = '';
        foreach (array_keys($this->options) as $key) {
            $value = $this->getOption($key);
            if ($value !== null) {
                $args .= sprintf("-%s '%s' ", $key, $value);
            }
        }
        $args .= "'" . $this->getInput() . "'";
        return $args;
    }

    public function exec()
    {
        if ($this->getInputData()) {
            $this->setInput(tempnam(null, null));
            $this->setOutput(tempnam(null, null));
            file_put_contents($this->getInput(), $this->getInputData());
        }

        $ret = parent::exec();

        if ($this->getInputData()) {
            $outFile = $this->getOutput();
            $this->setOutput($this->readOutput());
            unlink($this->getInput());
            unlink($outFile);
        }
        return $ret;
    }


}
 