<?php
//created some options which is an http array that contains an array within it. 
//User-Agent lets the website know who has visited and it's a GET request type.
// the array is ilke a dictionary where each item is specified by a name
//we're making a request to a website, passing in the url, and requesting the contents of 
//the website to be passed into the DomDocument Object

class DomDocumentParser {

    public function __construct($url) {

        $options = array(
            'http'=>array('method'=>"GET", 'header'=> "User-Agent: foodleBot/0.1\n")
        );
        $context = stream_context_create($options);
        $this->doc = new DomDocument();  //allows you to perform actions on web pages (PHP Function)
        @$this->doc->loadHTML(file_get_contents($url, false, $context)); //@sign removes warnings / errors
     }
    
     public function getLinks() {                                   //get anchor tags
        return $this->doc->getElementsByTagName("a");  
    }
    public function getTitleTags() {                                //get Title tags
        return $this->doc->getElementsByTagName("title");  
    }
    public function getMetaTags() {                                 //get Meta tags
        return $this->doc->getElementsByTagName("meta");  
    }
    public function getImages() {                                   //get images
        return $this->doc->getElementsByTagName("img");  
    }
}



?>