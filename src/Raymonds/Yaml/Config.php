<?php

declare(strict_types=1);

namespace Raymonds\Yaml;

use Raymonds\Base\Exception\BaseException;
use Symfony\Component\Yaml\Yaml;

class Config
{
    private function fileExists(string $fileName)
    {
        if (!is_file($fileName)) {
            throw new BaseException($fileName . ' does not exist');
        }
    }

    public function getYaml(string $yamlFile)
    {
        $file = CONFIG_PATH . DS . $yamlFile . '.yaml';
        $this->fileExists($file);
        return Yaml::parseFile($file);
    }

    public static function file(string $yamlFile)
    {
        return (new self)->getYaml($yamlFile);
    }
}
