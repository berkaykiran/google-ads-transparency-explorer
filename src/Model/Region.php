<?php

namespace Model;

class Region
{
    private $region_code;
    private $region_alpha_2;
    private $region_name;

    public function __construct($region_code, $region_alpha_2, $region_name)
    {
        $this->region_code = $region_code;
        $this->region_alpha_2 = $region_alpha_2;
        $this->region_name = $region_name;
    }

    public function getRegionCode()
    {
        return $this->region_code;
    }

    public function getRegionAlpha2()
    {
        return $this->region_alpha_2;
    }

    public function getRegionName()
    {
        return $this->region_name;
    }
}
