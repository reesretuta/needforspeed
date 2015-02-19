<?php

// Weeeeeeeeeeeeeeeee
function &getCarAssetAttributes() {
    if(!class_exists('CarAssetAttributes')) {
        require_once("carAttributesObject.php");
    }
    $returnVar = &CarAssetAttributes::Instance()->get();
    return $returnVar;
}

function setUserCarInfo(&$userInfo, $carAssetAttributes = null) {
    if($carAssetAttributes == null)
        $carAssetAttributes = &getCarAssetAttributes();

    $modelId = $userInfo['car'];
    //set user car folder
    if($modelId == null)
        return -1;

    if($userInfo['car_mods'] == null) {
        $userInfo['car_mods'] = $carAssetAttributes['byModalId'][$modelId]['default'];
    } else if(is_array($userInfo['car_mods'])) {
        foreach($userInfo['car_mods'] as $category => $value) {
            if(intval($value) <= 0) {
                $userInfo['car_mods'][$category] = $carAssetAttributes['byModalId'][$modelId]['default'];
            }
        }
    } else if(is_string($userInfo['car_mods'])) {
        //layer order is shadow - 2-wheels - color - tint - spoiler - decal
        $carModParts = str_split($userInfo['car_mods']);
        $userInfo['car_mods'] = array();
        foreach($carModParts as $index => $value) {
            $layerName = $carAssetAttributes['layerOrder'][$index];
            if(intval($value) <= 0) {
                $userInfo['car_mods'][$layerName] = $carAssetAttributes['byModalId'][$modelId]['default'][$layerName];
            } else {
                $userInfo['car_mods'][$layerName] = $value;
            }
        }
    } else {
        //error
        return -1;
    }
}

function getAvailableCars($phase,$carAttributes = null) {
    if($carAttributes == null)
        $carAttributes = &getCarAssetAttributes();
    $carsAvailable = array();

    if($phase == 1) {
        for($i=3; $i<6; $i++) {
            $carsAvailable[] = array(
                'name' => $carAttributes["byModalId"][$i]['name'],
                'srcImg' => getCarImagePath($carAttributes["byModalId"][$i]),
                'model' => $i
            );
        }
    }
    for($i=0; $i<3; $i++) {
        $carsAvailable[] = array(
            'name' => $carAttributes["byModalId"][$i]['name'],
            'srcImg' => getCarImagePath($carAttributes["byModalId"][$i]),
            'model' => $i
        );
    }
    return $carsAvailable;
}


//layer order is shadow - 2-wheels - color - tint - spoiler - decal
//function takes in a list of
function getCarImagePath($myCarSettings) {
    $carAssetAttributes = &getCarAssetAttributes();

    if(isset($myCarSettings['modalId'])) {
        $modalId = $myCarSettings['modalId'];
        $myCarSettings = $carAssetAttributes["byModalId"][$modalId]["default"];
    } else if(isset($myCarSettings['car_mods']) && isset($myCarSettings['car'])) {      //this is userInfo
        if($myCarSettings['car'] !== null)
            $modalId = $myCarSettings['car'];
        else
            return '';

        if($myCarSettings['car_mods'] !== null)
            $myCarSettings = $myCarSettings['car_mods'];
        else
            $myCarSettings = $carAssetAttributes["byModalId"][$modalId]["default"];

    } else {
        //error
        return '';
    }

    $imagePath = '' . $carAssetAttributes['assetPath'];
    $imagePath .= $carAssetAttributes["byModalId"][$modalId]['folder'] . "/";


    foreach($carAssetAttributes['layerOrder'] as $layer) {
        if(isset($myCarSettings[$layer])) {
            $imagePath .= $myCarSettings[$layer];
        } else {
            return '';
        }
    }
    $imagePath .= ".png";

    return $imagePath;
};

?>