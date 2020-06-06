<?php


namespace App\Inspections;

use Exception;
class invalidKeywords
{
    protected $keywords = [
        'musab only'
    ];

    /**
     * @param $body
     * @throws Exception
     */
    public function detect($body){
        foreach ($this->keywords as $keyword){
            if (stripos($body,$keyword) !== false){
                throw new Exception('Your Reply Content Spam');
            }
        }
    }
}