<?php
declare(strict_types=1);

namespace App\Model\DataLoader;

class DataLoader implements DataLoaderInterface
{
    /**
     * @var false|string
     */
    private $file;


    public function __construct()
    {
        $this->file = file_get_contents($this->getPathToFile());
    }

    /**
     * @return false|mixed
     */
    public function load(): mixed
    {
        $result = json_decode($this->file, true);
        if(json_last_error() === 0) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    private function getPathToFile(): string
    {
        $dir = explode('/', __DIR__);
        array_splice($dir, -2);
        return implode('/', $dir) . '/Data/input.txt';
    }
}
