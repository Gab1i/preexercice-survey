<header>
    <h1>Titre du questionnaire</h1>
    <h2>Nouvelle question</h2>
</header>

<main>
    <form action = 'admin/add' method = 'POST' id = 'new_question' >
        <div class = 'question_new type'>
            <label for = 'question_type'>Type de question</label>
            <select name = 'question_type' id = 'question_type'>
                <option value = '0'>Texte libre</option>
                <option value = '1'>Echelle</option>
            </select>
        </div>

        <div class = 'question_new type'>
            <label for = 'question'>Entrez votre question</label>
            <textarea name = 'question' id = 'question'></textarea>
        </div>

        <input type = 'submit' value = 'Envoyer' />
    </form>
</main>
