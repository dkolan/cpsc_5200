<?php include("top.html"); ?>

<div>
    <form action="signup-submit.php" method="post">
        <fieldset>
            <legend>New User Signup:</legend>
            <strong><label class="column">Name:</label></strong>
            <input name="name" type="text" size="16"> <br/>
            <strong><label class="column">Gender:</label></strong>
            <input type="radio" name="gender" value="male"> Male <input type="radio" name="gender" value="female" checked="checked"> Female <br/>
            <strong><label class="column">Age:</label></strong>
            <input name="age" type="text" size="6" maxlength="2"> <br/>
            <strong><label class="column">Personality type:</label></strong>
            <input name="personality" type="text" size="6" maxlength="42"> (<a href="https://www.humanmetrics.com/personality">Don't know your type?</a>) <br/>
            <strong><label class="column">Favorite OS:</label></strong>
            <select name="os">
                <option selected="selected">Windows</option>
                <option>Mac OS X</option>
                <option>Linux</option>
            </select> <br/>
            <strong><label class="column">Seeking age:</label></strong>
            <input name="ageMin" type="text" placeholder="min" size="6" maxlength="2"> to <input name="ageMax" type="text" placeholder="max" size="6" maxlength="2"> <br/>
            <input type="submit" value="Sign Up" />
        </fieldset>
    </form>
</div>

<?php include("bottom.html"); ?>