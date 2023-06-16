<?php include("top.html"); ?>

<div>
    <form action="matches-submit.php" method="get">
        <fieldset>
            <legend>Returning User:</legend>
            <strong><label class="column">Name:</label></strong>
            <input class="column" name="name" type="text" size="16" required="true"><br/><br/>
            <input type="submit" value="View My Matches" />
        </fieldset>
    </form>
</div>

<?php include("bottom.html"); ?>