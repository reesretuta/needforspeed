<?php
//Singleton Class
final class CarAssetAttributes {

    public static function Instance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new CarAssetAttributes();
        }
        return $inst;
    }

    private function __construct(){

    }

    public function &get() {        //returns reference to object
        return $this->carAssetAttributes;
    }

    public function getObjectForJavascript($modalId = null) {
        if(count($this->jsCarAttributes) == 0) {
            //initialize
            $this->jsCarAttributes["assetPath"] = $this->carAssetAttributes["assetPath"];
            $this->jsCarAttributes["layerOrder"] = $this->carAssetAttributes["layerOrder"];

            $this->jsCarAttributes['byModalId'] = array();
            if($modalId === null) {
                foreach($this->carAssetAttributes["byModalId"] as $id => $attr) {
                    $this->jsCarAttributes['byModalId'][$id]['default'] = $attr['default'];
                    $this->jsCarAttributes['byModalId'][$id]['name'] = $attr['name'];
                    $this->jsCarAttributes['byModalId'][$id]['folder'] = $attr['folder'];
                }
            } else {
                $this->jsCarAttributes['byModalId'][$modalId]['name'] = $this->carAssetAttributes['byModalId'][$modalId]['name'];
                $this->jsCarAttributes['byModalId'][$modalId]['folder'] = $this->carAssetAttributes['byModalId'][$modalId]['folder'];
            }
        }
        return $this->jsCarAttributes;
    }


    private $jsCarAttributes = array();
    private $carAssetAttributes = array(    //maintain this list only
        "maxNumAttributes" => array(
            "shadow" => 3,
            "wheels" => 4,
            "spoiler" => 5,
            "color" => 6,
            "tint" => 5,
            "decal" => 5
        ),
        "assetPath" => "/media/assets/",
        "layerOrder" => array("shadow","wheels","spoiler","color","tint","decal"),
        "byModalId" => array(
            0 => array(
                "default" => array(
                    "color" => 1,
                    "wheels" => 1,
                    "shadow" => 1,
                    "tint" => 1,
                    "spoiler" => 1,
                    "decal" => 1
                ),
                "modalId" => 0,
                "name" => "Gran Torino",
                "folder" => "GranTorino",
            ),
            1 => array(
                "default" => array(
                    "color" => 5,
                    "wheels" => 1,
                    "shadow" => 1,
                    "tint" => 1,
                    "spoiler" => 1,
                    "decal" => 1
                ),
                "modalId" => 1,
                "name" => "Shelby GT500",
                "folder" => "Shelby_GT500"
            ),
            2 => array(
                "default" => array(
                    "color" => 1,
                    "wheels" => 1,
                    "shadow" => 1,
                    "tint" => 1,
                    "spoiler" => 1,
                    "decal" => 1
                ),
                "modalId" => 2,
                "name" => "Spyder XR",
                "folder" => "Spyder_XR"
            ),
            3 => array(
                "default" => array(
                    "color" => 1,
                    "wheels" => 1,
                    "shadow" => 1,
                    "tint" => 1,
                    "spoiler" => 1,
                    "decal" => 1
                ),
                "modalId" => 3,
                "name" => "2015 Ford Mustang",
                "folder" => "2015_Ford_Mustang"
            ),
            4 => array(
                "default" => array(
                    "color" => 1,
                    "wheels" => 1,
                    "shadow" => 1,
                    "tint" => 1,
                    "spoiler" => 1,
                    "decal" => 1
                ),
                "modalId" => 4,
                "name" => "Sports GT",
                "folder" => "Sports_GT"
            ),
            5 => array(
                "default" => array(
                    "color" => 1,
                    "wheels" => 1,
                    "shadow" => 1,
                    "tint" => 1,
                    "spoiler" => 1,
                    "decal" => 1
                ),
                "modalId" => 5,
                "name" => "Velo Sport MG",
                "folder" => "VeloSport_MG"
            ),
        )
    );
}



?>