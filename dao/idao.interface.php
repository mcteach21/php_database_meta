<?php
/**
 * mc@2021
 */
interface IDao
{
    public function all();
    public function get($id);
    public function add($item);
    public function update($item);
    public function delete($item);
}