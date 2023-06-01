<?php include("top.html"); ?>

<form action="signup-submit.php" method="post">
    <fieldset>
        <legend>New User Signup:</legend>
        <strong><label class="left">Name:</label></strong>
        <input name="name" type="text" size="16"> <br/>
        <strong><label class="left">Gender:</label></strong>
        <input type="radio" name="gender" value="male"> Male <input type="radio" name="gender" value="female" checked="checked"> Female <br/>
        <strong><label class="left">Age:</label></strong>
        <input name="age" type="text" size="6" maxlength="2"> <br/>
        <strong><label class="left">Personality type:</label></strong>
        <input name="personality" type="text" size="6" maxlength="42"> (<a href="https://www.humanmetrics.com/personality">Don't know your type?</a>) <br/>
        <strong><label class="left">Favorite OS:</label></strong>
        <select name="os">
            <option selected="selected">Windows</option>
            <option>Mac OS X</option>
            <option>Linux</option>
        </select> <br/>
        <strong><label class="left">Seeking age:</label></strong>
        <input name="ageMin" type="text" placeholder="min" size="6" maxlength="2"> to <input name="ageMax" type="text" placeholder="max" size="6" maxlength="2"> <br/>
        <input type="submit" value="Sign Up" />
    </fieldset>
</form>

<?php include("bottom.html"); ?>