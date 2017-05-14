<?php

namespace Domain\ETFSP500;

class MonthlyAverageCollection implements \Iterator
{
    private $rows = [];

    private $index = 0;

    public function count() : int
    {
        return count($this->rows);
    }

    public function add(MonthlyAverage $monthlyAverage)
    {
        $this->rows[] = $monthlyAverage;
    }

    public function current()
    {
        return $this->rows[$this->index];
    }

    public function next()
    {
        $this->index++;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return isset($this->rows[$this->index]);
    }

    public function rewind()
    {
        $this->index = 0;
    }
}