<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-25
 * Time: 16:39
 */

namespace Hexmedia\Crontab;

use Hexmedia\Crontab\Exception\UnsupportedVariableException;

class Variables implements \Iterator
{
    private $currentIndex = 0;
    private $values = array();
    private $keys = array();

    private $allowedVariables = array("MAILTO", "SHELL", "PATH");

    public function __construct(array $variables)
    {
        $this->checkIfCorrect($variables);

        $this->values = $variables;
        $this->keys = array_keys($variables);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->values[$this->keys[$this->currentIndex]];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->currentIndex++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->keys[$this->currentIndex];
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->keys[$this->currentIndex]) && isset($this->values[$this->keys[$this->currentIndex]]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->currentIndex = 0;
    }

    private function checkIfCorrect(array $variables)
    {
        //TODO: I think that it can be any variable so...
//        foreach ($variables as $name => $value) {
//            if (!in_array($name, $this->allowedVariables)){
//                throw new UnsupportedVariableException(sprintf("Variable %s is not supported.", $name));
//            }
//        }

    }
}
