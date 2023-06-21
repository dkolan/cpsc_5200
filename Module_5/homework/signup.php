<!-- 
Dan Kolan
CPSC 5200 Web Development I
Project 4: NerdLuv (HTML Forms and PHP)

In this page I collect the user input needed to sign up for an account in a fieldset.
Then I submit the data via a POST to signup-submit.php for further processesing.
-->
<?php include("top.html"); ?>

<div>
    <form action="signup-submit.php" method="post">
        <fieldset>
            <legend>New User Signup:</legend>
            <p>
                <strong><label class="left">Name:</label></strong>
                <input name="name" type="text" size="16">
            </p>
            <p>
                <strong><label class="left">Gender:</label></strong>
                <input type="radio" name="gender" value="male"> Male <input type="radio" name="gender" value="female" checked="checked"> Female
            </p>
            <p>
                <strong><label class="left">Age:</label></strong>
                <input name="age" type="text" size="6" maxlength="2">
            </p>
            <p>
                <strong><label class="left">Personality type:</label></strong>
                <input name="personality" type="text" size="6" maxlength="4"> (<a href="https://www.humanmetrics.com/personality">Don't know your type?</a>)
            </p>
            <p>
                <strong><label class="left">Favorite OS:</label></strong>
                <select name="os">
                    <option selected="selected">Windows</option>
                    <option>Mac OS X</option>
                    <option>Linux</option>
                </select>
            </p>
            <p>
                <strong><label class="left">Seeking age:</label></strong>
                <input name="ageMin" type="text" placeholder="min" size="6" maxlength="2"> to <input name="ageMax" type="text" placeholder="max" size="6" maxlength="2">
            </p>
            <p>
                <input type="submit" value="Sign Up" />
            </p>
        </fieldset>
    </form>
</div>

<?php include("bottom.html"); ?>