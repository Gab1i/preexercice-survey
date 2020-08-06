<header>
    <h1>Titre du questionnaire</h1>
</header>

<main>
    <?php
    if($error) {?>
        <div class = 'alert-box warning'>
            <span>Attention : </span>certains champs n'ont pas été correctement remplis,<br />
            vérifiez que vous avez bien saisi votre nom et une adresse mail valide.
        </div>
        <?php
    }
    ?>
    <p id = 'desc'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    <form action = '#' method = 'POST' id = 'survey' >
        <?php
        foreach ($questions as $key => $question) {
            ?>
            <div class = 'question'>
            <?php
            if($question['type'] == 0) {
                ?>
                <label for = 'q_<?= $question['id_question']?>' class = 'intitule'><?= $question['question_order'] . '. ' . $question['text'] ?></label>
                <textarea name = 'q_<?= $question['id_question']?>'></textarea>
                <?php
            } else {
                ?>
                <p class = 'intitule'><?= $question['question_order'] . '. ' . $question['text'] ?></p>

                <div class = 'radios'>
                    <div>
                      <input type = 'radio' id = 'rep_<?= $question['id_question']?>1' name = 'q_<?= $question['id_question']?>' value = '1' >
                      <label for = 'rep_<?= $question['id_question']?>1'>1</label>
                    </div>

                    <div>
                      <input type = 'radio' id = 'rep_<?= $question['id_question']?>2' name = 'q_<?= $question['id_question']?>' value = '2' >
                      <label for = 'rep_<?= $question['id_question']?>2'>2</label>
                    </div>

                    <div>
                      <input type = 'radio' id = 'rep_<?= $question['id_question']?>3' name = 'q_<?= $question['id_question']?>' value = '3' checked>
                      <label for = 'rep_<?= $question['id_question']?>3'>3</label>
                    </div>

                    <div>
                      <input type = 'radio' id = 'rep_<?= $question['id_question']?>4' name = 'q_<?= $question['id_question']?>' value = '4' >
                      <label for = 'rep_<?= $question['id_question']?>4'>4</label>
                    </div>

                    <div>
                      <input type = 'radio' id = 'rep_<?= $question['id_question']?>5' name = 'q_<?= $question['id_question']?>' value = '5' >
                      <label for = 'rep_<?= $question['id_question']?>5'>5</label>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
            <?php
        }
        ?>

        <section id = 'user_info'>
            <p>Pour terminer, parlez-nous un petit peu de vous...</p>

            <div>
                <label for = 'name'>Votre nom</label>
                <input type = 'text' id = 'name' name = 'name' />
            </div>

            <div>
                <label for = 'mail'>Votre mail</label>
                <input type = 'mail' id = 'mail' name = 'mail' />
            </div>
        </section>


        <input type = 'submit' value = 'Envoyer' />
    </form>
