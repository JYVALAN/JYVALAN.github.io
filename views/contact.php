<main class="otherpage">
    <h2 class="title">En quoi pouvons-nous être utile?</h2>
    <p class="sentence">Lorem, ipsum dolor sit amet consectetur adipisicing elit. <br>In officiis ut repellendus! Eveniet sed facere quae tempora, neque quo id sequi officiis nulla esse molestias quod reiciendis, saepe labore quibusdam!</p>
    <fieldset class="contactfield">
        <form action="index.php?page=<?php echo PAGE_CONTACT; ?>" method="POST">
            <div>
                <input required class="contactinput" id="author" name="field_author" type="text" placeholder="votre nom" />
            </div>
            <div>
                <input required id="email" class="contactinput" name="field_email" type="text" placeholder="votre email" />
            </div>
            <div>
                <input required id="subject" class="contactinput" name="field_subject" type="text" placeholder="objet du message" />
            </div>
            <div>
                <textarea required id="content" class="contactarea" name="field_content" placeholder="votre message ici..."></textarea>
            </div>
            <button name="form_contact" value="contact" class="send">Envoyer</button>

            <input type="hidden" name="page" value="contact" class="contactinput" />
        </form>
    </fieldset>
</main>
