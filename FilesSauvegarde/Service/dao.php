<?php
/*Created by hamza */
interface dao
{
    function add($o);
    function update($o);
    function delete($o);
    function findbyid($id);
    function findall();
}
?>