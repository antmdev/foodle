<?php

include("classes/DomDocumentParser.php");

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

function followLinks($url) {

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
        echo $href . "<br>";
        }
    }

$startUrl = "http://www.facebook.com"; //change this for different sites
followLinks($startUrl);

?>