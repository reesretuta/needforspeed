<?php
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
/************************** Alec's Fuck Yeah Let's Generate Html Helper Functions ********************************/
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//

/*
 Takes in a string and an array of properties. Inserts each property into the string where it can by
 replacing instances of the property name surrounded by '%'

 Example Usage:
 -- Input --
 $htmlString = "<div class='%class%' data-foo='%bar%'></div>";
 $array = ['class' => 'active','bar' => 0];

 -- Output --
 "<div class='active' data-foo='0'></div>";
*/
function propertyStringReplace($htmlString, $array) {
    foreach($array as $property => $value) {
        $htmlString = str_replace('%'.$property.'%', $value, $htmlString);
    }
    return $htmlString;
}


 /*
 Generates and compounds the HTML strings for each item in a list by running propertyStringReplace
 $skeletonHtml = Array of strings that need to be generated into Html.
 $items = List of Items, each with a matching set of properties
 $specialCases = Properties you want to apply to only certain members of the item list. Array of those properties and
   their replacement values at certain Indexes of the items list. places an empty string if no replacement value exists.
   Also works if assigned to keys rather than index.

 Example Usage:
 -- Input --
 $skeletonHtml = ['div' => "<div id='%id%' class='%class%'></div>",'link' => "<a class='%linkClass%' href='#%id%'>Click Me</a>"]

 $items = [ ['id' => 0], ['id' => 1], ['id' => 3], ['id' => 4] ];
 $specialCases = [1 => ['class' => 'active', 'linkClass' => 'active'], 3 => ['linkClass' => 'blue'] ];

 ~~ So for index 1 we add "active" to the div's class and link's class, on index 3 we set the link to class="blue". Id's
    go on every item.


 -- Output --
 $returnHtml['div'] =
 <div id='0' class=''></div>
 <div id='1' class='active'></div>
 <div id='3' class=''></div>
 <div id='4' class=''></div>

 $returnHtml['link'] =
 <a class='' href='#0'>Click Me</a>
 <a class='active' href='#1'>Click Me</a>
 <a class='' href='#3'>Click Me</a>
 <a class='blue' href='#4'>Click Me</a>
*/
function generateCompoundedHtml($skeletonHtmlList, $items, $specialCases = null) {
    $nL = "\xA";    //new line
    $specialCaseSearchValues = array();
    $returnHtml = array();

    if(!is_array($skeletonHtmlList))    //if passed a single string, turn it into array with 1 element
        $skeletonHtmlList = array($skeletonHtmlList);

    if(!is_array(array_shift(array_values($items)))) {  //checks if first element of items is an array or properties
        $items = array($items);
    }


    if(is_array($specialCases)) {
        //if this only a single list of properties, we create a new aray and set those as default
        if(!is_array(array_shift(array_values($specialCases)))) {
            $specialCases = array('default' => $specialCases);
        }

        //Not required. If default values are not set then we compile a list of all keys and set their default value to ''
        //we don't examine default in $specialCases if it is a key in $items
        if(isset($specialCases['default']) && !isset($items['default'])) {
            foreach($specialCases['default'] as $key => $property) {
                $specialCaseSearchValues[$key] = $property;
            }
        } else {
            foreach($specialCases as $caseProperties) {
                foreach($caseProperties as $key => $property) {
                    $specialCaseSearchValues[$key] = '';
                }
            }
        }
    }

    $defaultValues = $specialCaseSearchValues;

    foreach($skeletonHtmlList as $name => $skeletonHtml) {
        $i = 0;
        $returnHtml[$name] = '';

        //get each item and it's properties, check if there is a special case of the item's Index or Key
        foreach($items as $id => $itemProperties) {
            if(isset($specialCases[$id]) && is_string($id))
                $thisItemsSpecialCases = $specialCases[$id];
            elseif(isset($specialCases[$i]))
                $thisItemsSpecialCases = $specialCases[$i];
            else
                $thisItemsSpecialCases = array();



            if(is_array($thisItemsSpecialCases)) {
                foreach($thisItemsSpecialCases as $key => $value) {
                    $specialCaseSearchValues[$key] = $value;
                }
            }

            //store exceptions/defaults in an array of properties and merge with current properties for this item
            //add html for this div + new line preceding it.
            $returnHtml[$name] .= $nL . propertyStringReplace($skeletonHtml, array_merge($itemProperties, $specialCaseSearchValues));

            //reset special case values to default
            $specialCaseSearchValues = $defaultValues;
            $i++;
        }
    }

    if(count($returnHtml) == 1)
        return array_shift($returnHtml);
    return $returnHtml;
}

//Also var dump
function varDump($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
}








?>