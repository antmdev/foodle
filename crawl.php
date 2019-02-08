<?php

include("classes/DomDocumentParser.php");

$alreadyCrawled = array(); //contains old links already crawled
$crawling = array(); //conatins the ones we still need to do

//****************************************************************************************************/
// -- CREATE LINKS FUNCTION
//****************************************************************************************************/

function createLink($src, $url) {

    $scheme  = parse_url($url)["scheme"];               //http type
    $host  = parse_url($url)["host"];                   //www.reecekenney.com

    if(substr($src, 0, 2) == "//" ){                    //fix links that already have 2 // forward slash
        $src = parse_url($url)["scheme"] . ":" . $src;  //built in JS function-parse URLS and grab the Scheme join to domain
    } else if (substr($src, 0, 1) == "/" ) {            //fix links that have only 1 / forward slash
        $src = $scheme . "://" . $host . $src;  
    } else if (substr($src, 0, 2) == "./" ) {           //fix where if the first two chars are ./ 
        $src = $scheme . "://" . $host . dirname(parse_url($url)["path"]) . substr($src, 1);
                                                        // append scheme to correct format, grab the host name, start from $src first character
    } else if (substr($src, 0, 3) == "../" ) {          //fix where if the first two chars are ../ 
        $src = $scheme . "://" . $host . "/" . $src;
    } else if (substr($src, 0, 5) != "https" && substr($src, 0, 4) != "http") { //just amending if http(s) already in link
        $src = $scheme . "://" . $host . "/" . $src;
    }
    return $src;                                        // return the updated URL and assign it


                                                        // echo "SRC: $src <br>"; //Domain name
                                                        // echo "URL: $url <br>"; //Remainder of URL
                                                        // scheme: http / https
                                                        // host: www.reecekenney.com
}

//****************************************************************************************************/
// -- GET WEB DETAILS FUNCTION
//****************************************************************************************************/

function getDetails($url) {

    $parser = new DomDocumentParser($url); 

    $titleArray = $parser->getTitleTags();              //get title tags

    if (sizeof($titleArray) == 0 || $titleArray->item(0) == NULL) {         //make sure there's no empty titles
        return;
    }

    $title = $titleArray->item(0)->nodeValue;           // ensure we start from the first one (in case of multiple title tags)
    $title = str_replace("\n", "", $title);             // replace new lines with an empty string
    if($title == "") {                                  //ignore websites that don't have a title
        return;
    }



    echo "URL: $url, Title: $title <br>";

}

//****************************************************************************************************/
// -- RECURSSIVE LINK SEARCH FUNCTION
//****************************************************************************************************/

function followLinks($url) {

    global $alreadyCrawled;
    global $crawling;

    $parser = new DomDocumentParser($url); //set new instance of the class
   
    $linkList = $parser->getLinks(); //grab the anchor links from parser class

    foreach($linkList as $link) {
        $href = $link->getAttribute("href");

        if(strpos($href, "#") !== false) { //if you find a # in the anchor link just ignore it 
            continue;
        } else if(substr($href, 0, 11) == "javascript:") { //remove javascript links
            continue;
        }

        $href = createLink($href, $url);

            if(!in_array($href, $alreadyCrawled)) {                //if the value is not in the array
                $alreadyCrawled[] = $href;              //put the href into already crawled
                $crawling[] = $href;                    //also put it into crawling

                getDetails($href);                      //call function
            }

            else return;                                //stop running as soon as it finds it firts duplicate
            
        }

        array_shift($crawling); //this funtion then removes the value from the array as we dont need it anymore

        foreach($crawling as $site) { //loop through 
            followLinks($site);
    }

}

//****************************************************************************************************/
// -- START URL AREA
//****************************************************************************************************/

$startUrl = "http://www.facebook.com"; //change this for different sites
followLinks($startUrl);

?>