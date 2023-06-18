<!-- 
Dan Kolan
CPSC 5200 Web Development I
Project 4: NerdLuv (HTML Forms and PHP)

In this page I display and process the user information submitted via the POST
from signup.php.
-->
<?php include("top.html"); ?>

<div>
    <form action="matches-submit.php" method="get">
        <fieldset>
            <legend>Returning User:</legend>            
            <p>
                <strong><label class="column">Name:</label></strong>
                <input class="column" name="name" type="text" size="16" required="true"><br/>
            </p>    
            <input type="submit" value="View My Matches" />           
        </fieldset>
    </form>
</div>

<?php include("bottom.html"); ?>