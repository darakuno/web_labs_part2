<?php include("include/conf.php"); 
session_start(); ?>
<!DOCTYPE html>
<html>
<?php include("include/head.php"); ?>
    <body>
        <?php include("include/header.htm");
        
        if ($CURRENT_PAGE == "index")include_once $route["main"]; 
        else include_once $route[$CURRENT_PAGE]; ?>  
    </body>
    <?php include("include/footer.htm"); ?>
</html>

