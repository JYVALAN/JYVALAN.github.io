<main class="otherpage">
    <h2 class="title">Etes-vous prêt à découvrir des merveilles?</h2>
    <p class="sentence">Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>Obcaecati quam nobis magni ea culpa odio, <br> labore beatae eligendi minima repellat dolore, tempora aliquam nulla repellendus. Similique placeat ipsum veniam? Asperiores?</p>
    <fieldset class="signupfield">
        <form action="index.php?page=<?php echo PAGE_SIGNUP; ?>" method="POST">
            <h3 class="signupfree smalltitle">Inscription gratuite</h3>
            <div class="signupname">
                <input required type="text" name="field_lastname" class="signupinput" id="lastname" placeholder="nom">
                <input required type="text" name="field_firstname" class="signupinput" id="firstname" placeholder="prénom">
            </div>
            <div>
                <input required type="email" name="field_email" id="email" class="signupinput" placeholder="email">
            </div>
            <div>
                <input required type="password" class="signupinput" name="field_password" id="password" placeholder="mot de passe">
            </div>
            <button name="form_signup" value="signup" class="btnsign send">Inscription</button>
        </form>
    </fieldset>
</main>

