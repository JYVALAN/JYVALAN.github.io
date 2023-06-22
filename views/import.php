<main class="otherpage">
    <h2 class="importtitle title">Mettez en ligne votre œuvre</h2>
    <p class="importsentence">Le lorem ipsum est, en imprimerie, une suite de mots sans <br> signification utilisée à titre provisoire pour calibrer une mise en page, <br> le texte définitif venant remplacer le faux-texte dès qu'il est prêt ou que la </p>

    <fieldset class="importfield">
        <form method="POST" action="" enctype="multipart/form-data">
            <div>
                <input type="text" name="field_title" class="importinput" id="title" placeholder="nom de l’œuvre*">
            </div>
            <div>
                <select name="field_category" id="category" class="importselect" >
                    <?php
                    foreach ($categories as $oCategory) {
                        echo '<option value="' . $oCategory->getId() . '">' . $oCategory->getName() . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <textarea name="field_description" class="importarea" id="description" cols="30" rows="10" placeholder="description de l’image (facultatif)"></textarea>
            </div>
            <div>
                <input type="file" name="field_picture" id="picture" class="importinput">
            </div>
            <div id="insight"></div>
            <button class="send" name="form_new_picture">Partager</button>
        </form>
    </fieldset>
    <script src="./js/dropzone.js"></script>
</main>


