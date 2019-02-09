<?php

class SitesResultsProvider {

    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function getNumResults($term) {                  //get the number of results & results that match the term
        
        $query = $this->con->prepare("SELECT COUNT(*) AS total
                                        FROM sites WHERE title LIKE :term
                                        OR url LIKE :term
                                        OR keywords LIKE :term
                                        OR description LIKE :term");
        
        $searchTerm = "%" . $term . "%";                    //bind terms with % for SQL LIKE command

        $query->bindParam(":term", $searchTerm); 

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);             //assoc array = key:value array like dictionary

        return $row["total"];

    }
}

?>