<?php
/**
 * Created by IntelliJ IDEA.
 * User: brandencash
 * Date: 6/19/15
 * Time: 10:18 AM
 */

namespace MashupMill\Batik\Command;


interface Command
{
    /**
     * @return string The path to the command jar
     */
    public function getJarPath();

    /**
     * @return mixed
     */
    public function exec();
} 