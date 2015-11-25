<?php

namespace App\Lib\DsManager\Models;


/**
 * Class Module
 * @package App\Lib\DsManager\Models
 */
use App\Lib\Helpers\Config;

/**
 * Class Module
 * @package App\Lib\DsManager\Models
 */
class Module
{
    /**
     * @var
     */
    private $moduleCode;
    /**
     * @var
     */
    private $configuration;

    /**
     * @param $module
     */
    public function __construct($module)
    {
        $this->moduleCode = $module;
        $this->configuration = Config::get("modules.modules", "api/")[$module];
        if ($this->configuration == null) throw new \InvalidArgumentException("Not a valid Module supplied");
    }

    /**
     *
     */
    public function isOffensive()
    {
        return ($this->configuration["character"] === 1);
    }

    /**
     *
     */
    public function isBalanced()
    {
        return ($this->configuration["character"] === 2);
    }

    /**
     *
     */
    public function isDefensive()
    {
        return ($this->configuration["character"] === 4);
    }

    /**
     * @return string
     */
    function __toString()
    {
        return "" . $this->moduleCode;
    }


}