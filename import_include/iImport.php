<?php

interface iImport
{
    public function before($file);
    
    public function getItems($file);

    public function getFormatItem($item);
}