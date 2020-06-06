<?php


namespace App\Inspections;


class Spam
{
    protected $inspections = [
      invalidKeywords::class,
      KeyHeldDown::class
    ];

    public function detect($body){

        foreach ($this->inspections as $inspection){
            app($inspection)->detect($body);
        }

        return false;

    }


    /**
     * @param $body
     * @throws \Exception
     */
    public function detectKeyHeldDown($body){

    }
}