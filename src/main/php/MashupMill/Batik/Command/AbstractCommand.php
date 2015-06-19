<?php
/**
 * Created by IntelliJ IDEA.
 * User: brandencash
 * Date: 6/19/15
 * Time: 10:17 AM
 */
namespace MashupMill\Batik\Command;

abstract class AbstractCommand implements Command
{
    protected $version = '1.8';
    protected $jarName = 'batik';

    protected $options = array();
    protected $exitCode;
    protected $stdOut;

    /**
     * @return string The path to the command jar
     */
    public function getJarPath()
    {
        $root = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
        return sprintf('%s/lib/batik-%s/%s-%s.jar', $root, $this->getBatikVersion(), $this->getJarName(), $this->getBatikVersion());
    }


    public function exec()
    {
        exec($this->getCommand(), $output, $exit);
        $this->exitCode = $exit;
        $this->stdOut = implode($output, "\n");
        return $exit === 0;
    }

    /**
     * @return mixed
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * @return string
     */
    public function getStdOut()
    {
        return $this->stdOut;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return sprintf("java -jar '%s' %s 2>&1", $this->getJarPath(), $this->getArguments());
    }

    protected function getBatikVersion()
    {
        return $this->version;
    }

    protected function getJarName()
    {
        return $this->jarName;
    }

    /**
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function getOption($key, $default = null)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getArguments();
}
 