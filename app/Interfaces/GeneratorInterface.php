<?php


namespace App\Interfaces;


interface GeneratorInterface
{
    public function create();

    public function generatePaths();

    public function replaceStubs($stub);
}
