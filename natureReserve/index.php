<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include_once '../src/model/DataContext.php';
include_once '../src/model/natureReserves.php';

if(!isset($db)){  // checking if there is a value in the var, if not then create new instance of the variable.
    $db = new DataContext();
}

$sites = $db->natureReserves();  // declare a var that calls the function

if($sites){
    $code = 200;  // set http code to 200 = success.
    header_remove(); // remove headers
    http_response_code($code);  // sets the 200 code.
    header('Content-Type: application/json'); // set new headers
    header('Status: ' .$code);

    echo getSemanticMarkup($sites);  // echo outputs the string to screen.
}
else{
    http_response_code(404);  //set 404 for error.
    echo json_encode(array("message" => "No sites found."));  // show error message.
}

function getSemanticMarkup($response){
    $SemanticResult = '{ "@context" : { "Place" : "http://schema.org", "mdw" : "http://web.socem.plymouth.ac.uk" }, "place" : [';

    foreach ($response as $site) {

        $SemanticResult .= '{ "@type" : "Place",
        "siteName" : "'.$site->site().'",
        "area" : "'.$site->area().'",
        "owner" : "'.$site->ownership().'"},';
    }
    $SemanticResult = substr($SemanticResult, 0, -1);  // removes the trailing comma from the end.
    $SemanticResult .= ']}';

    return $SemanticResult;
}
function returnJSON($response, $code){  // this function returns the JSON data.
    header_remove();
    http_response_code($code);
    header('Content-Type: application/json');
    header('Status: '.$code);
    return json_encode(array('status' => $code, 'message' => $response));
}
