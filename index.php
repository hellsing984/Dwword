<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Hunter jugement – Vote fan</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="overlay"></div>
  <header class="hero">
    <h1>🌋 Site du jugement</h1>
    <p>Exprime ton choix de chasseur</p>
  </header>

  <form id="createVoteForm" class="create-vote-form" style="display:none;" method="post" action="vote.php">
    <label for="category">Choisissez une catégorie :</label>
    <select id="category" name="vote_type" required>
      <option value="" disabled selected>-- Sélectionnez --</option>
      <option value="monstre">🦖 Monstre préféré</option>
      <option value="arme">⚔️ Arme favorite</option>
      <option value="cuisine">🍲 Animation culinaire</option>
    </select>
    <div id="optionsContainer" style="margin-top: 1em;"></div>
    <button type="submit" disabled id="submitBtn">Voter maintenant</button>
  </form>

  <main class="container">
    <section class="vote-section">
      <h2>1. Catégorie Apprenant🧑🎓</h2>
      <div class="images-container">
        <img src="images/théo.png" alt="Théo" class="apprenant-img" data-vote="monstre" />
        <img src="images/JB.png" alt="JB" class="apprenant-img" data-vote="monstre" />
        <img src="images/kevin.png" alt="Kevin" class="apprenant-img" data-vote="monstre" />
        <img src="images/Sylvain.png" alt="Image4" class="apprenant-img" data-vote="monstre" />
        <img src="images/Romain.png" alt="Image5" class="apprenant-img" data-vote="monstre" />
        <img src="images/nadima.png" alt="Image6" class="apprenant-img" data-vote="monstre" />
      </div>
    </section>

    <section class="vote-section">
      <h2>2. Catégorie Formateur🧑🏫</h2>
      <div class="images-container">
        <img src="images/christophe.png" alt="christophe" class="formateur-img" data-vote="arme" />
        <img src="images/brenda.png" alt="brenda" class="formateur-img" data-vote="arme" />
        <img src="images/cedric.png" alt="cedric" class="formateur-img" data-vote="arme" />
        <img src="images/luc.png" alt="luc" class="formateur-img" data-vote="arme" />
        <img src="images/laetitia.png" alt="laetitia" class="formateur-img" data-vote="arme" />
      </div>
    </section>

    <?php
    $votes = [
      'monstre' => [
        'titre' => 'A - Apprenant🧑🎓',
        'options' => [
          '😀Le radieu - Prix destiné à l\'élève qui éblouit en passant.',
          '😇L’ami de tous - Prix destiné à l’élève le plus social.',
          '🥳Le fêtard - Prix destiné à l’élève le plus festif.',
          '🥵Le Titan du Travail - Prix destiné à l’élève le plus bosseur et sérieux.',
          '🤩Le Designer - Prix destiné à lʼélève qui adore le design et le front.',
          '🤓Le Codeur émérite - Prix destiné à l’élève qui sʼest marié avec le code.',
          '🤣La Fusée de l’Animation - Prix destiné à l’élève le plus fun, jamais à court de blague.',
          '😠Le râleur ou grincheux - Prix destiné à l’élève le plus frustré et grognon.'
        ]
      ],
      'arme' => [
        'titre' => 'B - Formateur🧑🏫',
        'options' => [
          '😌Le Défenseur de la Patience - Prix destiné au prof qui fait preuve d\'une patience exceptionnelle dans toutes les situations.',
          '🤪Le Comique Magistral - Prix destiné au prof qui apporte la joie et le rire dans la salle de classe avec son humour exceptionnel.',
          '😵L’étourdi - Prix destiné au prof maladroit, inattentif ou distrait.'
        ]
      ],
      'cuisine' => [
        'titre' => '🍲 Animation culinaire',
        'options' => ['Viande grillée', 'Soupe de monstres', 'Brochette géante']
      ]
    ];

    foreach ($votes as $type => $data):
    ?>
      <section class="vote-card" data-vote-type="<?php echo htmlspecialchars($type); ?>">
        <h2><?php echo htmlspecialchars($data['titre']); ?></h2>
        <?php if($type === 'cuisine'): ?>
          <div class="video">
            <iframe src="https://www.youtube.com/embed/MkKE_THW1HI" frameborder="0" allowfullscreen></iframe>
          </div>
        <?php endif; ?>
        <form method="post" action="vote.php">
          <input type="hidden" name="vote_type" value="<?php echo htmlspecialchars($type); ?>">
          <?php foreach ($data['options'] as $opt): ?>
            <label>
              <input type="radio" name="choice" value="<?php echo htmlspecialchars($opt); ?>" required>
              <?php echo htmlspecialchars($opt); ?>
            </label>
          <?php endforeach; ?>
          <button class="mhw-button" type="submit">Voter maintenant</button>
        </form>
      </section>
    <?php endforeach; ?>
  </main>

  <footer>
    &copy; <?php echo date("Y"); ?> Hunter jugement
  </footer>

  <script>
    // Système de formulaire personnalisé
    const categorySelect = document.getElementById('category');
    const optionsContainer = document.getElementById('optionsContainer');
    const submitBtn = document.getElementById('submitBtn');

    const optionsData = {
      monstre: ['Rathalos', 'Tigrex', 'Nergigante'],
      arme: ['Grande épée', 'Katana', 'Insectoglaive'],
      cuisine: ['Viande grillée', 'Soupe de monstres', 'Brochette géante']
    };

    categorySelect.addEventListener('change', () => {
      const selectedCat = categorySelect.value;
      optionsContainer.innerHTML = '';
      if (selectedCat && optionsData[selectedCat]) {
        optionsData[selectedCat].forEach(opt => {
          const label = document.createElement('label');
          const radio = document.createElement('input');
          radio.type = 'radio';
          radio.name = 'choice';
          radio.value = opt;
          radio.required = true;
          label.appendChild(radio);
          label.append(' ' + opt);
          optionsContainer.appendChild(label);
        });
        submitBtn.disabled = false;
      } else {
        submitBtn.disabled = true;
      }
    });

    // Fonction pour afficher certains types de vote
    function afficherVotes(typeToShow) {
      document.querySelectorAll('.vote-card').forEach(section => {
        const voteType = section.dataset.voteType;
        if (voteType === 'cuisine' || voteType === typeToShow) {
          section.style.display = 'block';
        } else {
          section.style.display = 'none';
        }
      });
    }

    // Clic sur un formateur => afficher arme + cuisine
    document.querySelectorAll('.formateur-img').forEach(img => {
      img.addEventListener('click', () => {
        afficherVotes('arme');
      });
    });

    // Clic sur un apprenant => afficher monstre + cuisine
    document.querySelectorAll('.apprenant-img').forEach(img => {
      img.addEventListener('click', () => {
        afficherVotes('monstre');
      });
    });
  </script>
</body>
</html>
