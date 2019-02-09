<?php

include("config.php");
include("classes/sitesResultsProvider.php");


    if(isset ($_GET["term"])) {
        $term = $_GET["term"];
    } else { 
        exit("You must enter a search term"); //ends all code after this point and displsays this message
    }
    $type = isset ($_GET["type"]) ? $_GET["type"] : "Sites" //shorthand version
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <title>Welcome to Foodle</title>
</head>

<body>

<div class="wrapper">   
    <div class="header">
        <div class="headerContent">

            <div class="logoContainer">
                <a href="index.php">
                    <img src="/doodle/assets/images/festisite_google.png" alt="google logo">
                </a>
                </div><!-- logoContainer --> 

                <div class="searchContainer">

                    <form action="search.php" method="GET">

                        <div class="searchBarContainer">
                        <input type="text" class="searchBox" name="term">
                        <button class="searchButton">
                        <img src="assets/images/icons/icons8-search-24.png">
                        </button>
                    
                    </form><!-- search Form -->
                </div><!-- searchBarContainer --> 

                
                </div><!-- searchContainer --> 
                </div> <!-- HeaderContent --> 
            
                <div class="tabsContainer">
                    <ul class="tabList">
                    <!-- Set class active if search type is sites or images or none  --> 
                        <li class = "<?php echo $type == 'sites' ? 'active' : '' ?> "> 
                            <a href="<?php echo 'search.php?term=$term&type=sites'; ?> ">
                            Sites
                            </a>
                        </li>
                        <li class = "<?php echo $type == 'images' ? 'active' : '' ?> ">
                            <a href="<?php echo 'search.php?term=$term&type=images'; ?> "> 
                            Images
                            </a>
                        </li>
                    </ul>

            </div><!-- tabsContainer -->
        </div> <!-- header -->  
       
    <div class="mainResultsSection">
          
   <?php

    $resultProvider = new SitesResultsProvider($con);

    $numResults = $resultProvider->getNumResults($term);

    echo "<p class='resultsCount'>$numResults results found</p>";

    echo $resultProvider->getResultsHtml(1, 20, $term);

    ?>

    </div><!-- mainResultsSection -->
    
</div> <!-- wrapper -->
</body>
</html>