<?php
/**
 *  Copyright (c) 2018 Danilo Andrade.
 *
 *  This file is part of the apli project.
 *
 * @project apli
 * @file IO.php
 *
 * @author Danilo Andrade <danilo@webbingbrasil.com.br>
 * @date 27/08/18 at 10:26
 */

namespace Apli\IO\Cli;

use Apli\IO\Cli\Input\BasicCliInput;
use Apli\IO\Cli\Input\CliInput;
use Apli\IO\Cli\Output\CliOutput;
use Apli\IO\Cli\Output\ColorfulCliOutput;

/**
 * Class BasicIO.
 */
class BasicIO implements IO
{
    /**
     * Property input.
     *
     * @var CliInput
     */
    protected $input = null;

    /**
     * Property output.
     *
     * @var CliOutput
     */
    protected $output = null;

    /**
     * Class init.
     *
     * @param CliInput  $input
     * @param CliOutput $output
     */
    public function __construct(CliInput $input = null, CliOutput $output = null)
    {
        $this->input = $input ?: new BasicCliInput();
        $this->output = $output ?: new ColorfulCliOutput();
    }

    /**
     * Write a string to standard output.
     *
     * @param string $text The text to display.
     * @param bool   $nl   True (default) to append a new line at the end of the output string.
     *
     * @return BasicIO Instance of $this to allow chaining.
     */
    public function out($text = '', $nl = true)
    {
        $this->output->out($text, $nl);

        return $this;
    }

    /**
     * Get a value from standard input.
     *
     * @return string The input string from standard input.
     */
    public function in()
    {
        return $this->input->in();
    }

    /**
     * Write a string to standard error output.
     *
     * @param string $text The text to display.
     * @param bool   $nl   True (default) to append a new line at the end of the output string.
     *
     * @return $this
     */
    public function err($text = '', $nl = true)
    {
        $this->output->err($text, $nl);

        return $this;
    }

    /**
     * Gets a value from the input data.
     *
     * @param string $name    Name of the value to get.
     * @param mixed  $default Default value to return if variable does not exist.
     *
     * @return mixed The filtered input value.
     */
    public function getOption($name, $default = null)
    {
        return $this->input->get($name, $default);
    }

    /**
     * Sets a value.
     *
     * @param string $name  Name of the value to set.
     * @param mixed  $value Value to assign to the input.
     *
     * @return BasicIO
     */
    public function setOption($name, $value)
    {
        $this->input->set($name, $value);

        return $this;
    }

    /**
     * setArgument.
     *
     * @param int   $offset
     * @param mixed $value
     *
     * @return BasicIO
     */
    public function setArgument($offset, $value)
    {
        $this->input->setArgument($offset, $value);

        return $this;
    }

    /**
     * getInput.
     *
     * @return CliInput
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * setInput.
     *
     * @param CliInput $input
     *
     * @return BasicIO Return self to support chaining.
     */
    public function setInput(CliInput $input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * getOutput.
     *
     * @return CliOutput
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * setOutput.
     *
     * @param CliOutput $output
     *
     * @return BasicIO Return self to support chaining.
     */
    public function setOutput(CliOutput $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * getExecuted.
     *
     * @return mixed
     */
    public function getCalledScript()
    {
        return $this->input->getCalledScript();
    }

    /**
     * getOptions.
     *
     * @return string[]
     */
    public function getOptions()
    {
        return $this->input->all();
    }

    /**
     * getArguments.
     *
     * @return string[]
     */
    public function getArguments()
    {
        return $this->input->args;
    }

    /**
     * Set value to property.
     *
     * @param mixed $offset Property key.
     * @param mixed $value  Property value to set.
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->input->getArgument($offset, $value);
    }

    /**
     * Unset a property.
     *
     * @param mixed $offset Key to unset.
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->input->args[$offset]);
    }

    /**
     * Property is exist or not.
     *
     * @param mixed $offset Property key.
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->input->args[$offset]);
    }

    /**
     * Get a value of property.
     *
     * @param mixed $offset Property key.
     *
     * @return mixed The value of this property.
     */
    public function offsetGet($offset)
    {
        return $this->getArgument($offset);
    }

    /**
     * getArgument.
     *
     * @param int   $offset
     * @param mixed $default
     *
     * @return mixed
     */
    public function getArgument($offset, $default = null)
    {
        return $this->input->getArgument($offset, $default);
    }

    /**
     * Get the data store for iterate.
     *
     * @return \Traversable The data to be iterator.
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->input->args);
    }

    /**
     * Serialize data.
     *
     * @return string Serialized data string.
     */
    public function serialize()
    {
        return serialize($this->input);
    }

    /**
     * Unserialize the data.
     *
     * @param string $serialized THe serialized data string.
     *
     * @return BasicIO Support chaining.
     */
    public function unserialize($serialized)
    {
        $this->input = unserialize($serialized);

        return $this;
    }

    /**
     * Count data.
     *
     * @return int
     */
    public function count()
    {
        return count($this->input->args);
    }

    /**
     * Serialize to json format.
     *
     * @return string Encoded json string.
     */
    public function jsonSerialize()
    {
        return [
            'arguments' => $this->input->args,
            'options'   => $this->input->all(),
        ];
    }
}
