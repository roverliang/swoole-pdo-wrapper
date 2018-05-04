<?php
namespace Kuaiapp\Db\Base;

use Iterator;

class Row implements Iterator
{
    private $position = 0;
    private $array = array('one', 'two', 'three');

    public function rewind()
    {
        echo __METHOD__;
        $this->position = 0;
    }

    public function current()
    {
        echo __METHOD__;
        return $this->array[$this->position];
    }

    public function key()
    {
        echo __METHOD__;
        return $this->position;
    }

    public function next()
    {
        echo __METHOD__;
        ++$this->position;
    }

    public function valid()
    {
        echo __METHOD__;
        return isset($this->array[$this->position]);
    }
}
