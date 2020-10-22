<?php

/**
 * Interface to make querys
 */

interface IQuery {
    public function select($array = null, $type = null);
    public function SqlRaw($query);
    public function where($array, $condition = "=", $type = "AND");
    public function join($table, $master = null);
    public function orderBy($alias, $column, $order); 
}
