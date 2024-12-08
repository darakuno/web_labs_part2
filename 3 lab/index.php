<?php include("conf.php"); ?>
<!DOCTYPE html>
<html>
<?php include("hat.htm"); ?>
    <body>
        <?php include("header.htm");
        if ($CURRENT_PAGE == "index")include_once $route["main"]; 
        else include_once $route[$CURRENT_PAGE]; ?>  
    </body>
    <?php include("footer.htm"); ?>
</html>

