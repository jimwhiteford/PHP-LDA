<?php

class natureReserves{
    private $site; // declared variables in data set types
    private $area;
    private $ownership;

    public function __construct($Site, $Area, $Ownership){ // bring parameters in and assign to variables.
        $this->site = $Site;
        $this->area = $Area;
        $this->ownership = $Ownership;
    }

    public function site(){  // functions created to output data instead of getter and setter
        return $this->site;
    }

    public function area(){
        return $this->area;
    }

    public function ownership(){
        return $this->ownership;
    }
}