<header>
    <h1>Titre du questionnaire</h1>
</header>

<main>

<div id = 'dashboard_results'>
    <p>Nombre de réponses: <?= $nbAnswers ?></p>

    <a <?php if($nbAnswers > 0) {?> href = 'admin/results' <?php } else { ?> class = 'unavailable' <?php } ?> class = 'btn_results'>Télécharger les résultats (.csv)</a>
</div>

<section id = 'edit'>
    <h2>Modifier le questionnaire</h2>

    <?php
    foreach ($questions as $key => $question) {
        ?>
        <div class = 'question_admin'>
            <p>
                <?= $question['question_order'] . '. ' . $question['text'] ?> <a href = 'admin/delete/<?= $question['id_question'] ?>' class = 'delete'></a>
                <?php if($question['question_order'] != count($questions)) {
                    ?>
                    <a href = '#'>Descendre</a>
                    <?php
                }
                if($question['question_order'] != 1) {
                    ?>
                    <a href = '#'>Monter</a>
                    <?php
                } ?>
            </p>
        </div>
        <?php
    }
    ?>

    <a href = 'admin/new' id = 'btn_add'>Ajouter une question</a>
</section>
