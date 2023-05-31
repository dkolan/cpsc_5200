<?php include("top.html"); ?>

<form action="signup-submit.php" method="post">
    <fieldset>
        <legend>New User Signup:</legend>
        <label class="left">Name:</label>
        <input name="name" type="text" size="16"> <br/>
        <label class="left">Gender:</label>
        <input type="radio" name="gender" value="male"> Male <input type="radio" name="gender" value="female" checked="checked"> Female <br/>
        <label class="left">Age:</label>
        <input name="age" type="text" size="6" maxlength="2"> <br/>
        <label class="left">Personality type:</label>
        <input name="personality" type="text" size="6" maxlength="42"> (<a href="https://www.humanmetrics.com/personality">Don't know your type?</a>) <br/>
        <label class="left">Favorite OS:</label>
        <select name="os">
            <option selected="selected">Windows</option>
            <option>Mac OS X</option>
            <option>Linux</option>
        </select> <br/>
        <label class="left">Seeking age:</label>
        <input name="ageMin" type="text" placeholder="min" size="6" maxlength="2"> to <input name="ageMax" type="text" placeholder="max" size="6" maxlength="2"> <br/>
        <input type="submit" value="Sign Up" />
    </fieldset>
</form>

<?php include("bottom.html"); ?>