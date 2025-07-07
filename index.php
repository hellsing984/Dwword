<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Monster Hunter Wilds – Vote fan</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="overlay"></div>
  <header class="hero">
    <h1>🌋 Monster Hunter Wilds Fan Voting</h1>
    <p>Exprime ton choix de chasseur</p>
  </header>

  <!-- BOUTON CREER VOTE -->
  <button id="createVoteBtn" class="mhw-button">Créer un vote</button>

  <!-- FORMULAIRE CREATION VOTE -->
  <form id="createVoteForm" class="create-vote-form">
    <label for="newTitle">Nom de la catégorie</label>
    <input type="text" id="newTitle" placeholder="Ex : Monture préférée" required />

    <label for="newOptions">Options (séparées par des virgules)</label>
    <textarea id="newOptions" placeholder="Ex : Aknosom, Lagombi, Palamute" required></textarea>

    <button type="submit" class="mhw-button">Ajouter la catégorie</button>
  </form>

  <main class="container">
    <?php
      $votes = [
        'monstre' => ['titre' => '🦖 Monstre préféré', 'options' => ['Rathalos', 'Tigrex', 'Nergigante']],
        'arme' => ['titre' => '⚔️ Arme favorite', 'options' => ['Grande épée', 'Katana', 'Insectoglaive']],
        'cuisine' => ['titre' => '🍲 Animation culinaire', 'options' => ['Viande grillée', 'Soupe de monstres', 'Brochette géante']]
      ];
      foreach ($votes as $type => $data):
    ?>
      <section class="vote-card">
        <h2><?php echo htmlspecialchars($data['titre']); ?></h2>
        <?php if($type === 'cuisine'): ?>
          <div class="video">
            <iframe src="https://www.youtube.com/embed/MkKE_THW1HI" frameborder="0" allowfullscreen></iframe>
          </div>
        <?php endif; ?>
        <form method="post" action="vote.php">
          <input type="hidden" name="vote_type" value="<?php echo htmlspecialchars($type); ?>">
          <?php foreach ($data['options'] as $opt): ?>
            <label><input type="radio" name="choice" value="<?php echo htmlspecialchars($opt); ?>"> <?php echo htmlspecialchars($opt); ?></label>
          <?php endforeach; ?>
          <button class="mhw-button" type="submit">Voter maintenant</button>
        </form>
      </section>
    <?php endforeach; ?>
  </main>

  <footer>
    &copy; <?php echo date("Y"); ?> Monster Hunter Wilds Fan Page
  </footer>

  <script>
    const btn = document.getElementById('createVoteBtn');
    const form = document.getElementById('createVoteForm');
    const votesContainer = document.querySelector('.container');

    btn.addEventListener('click', () => {
      if (form.style.display === 'block') {
        form.style.display = 'none';
        btn.textContent = 'Créer un vote';
      } else {
        form.style.display = 'block';
        btn.textContent = 'Fermer le formulaire';
        form.scrollIntoView({ behavior: 'smooth' });
      }
    });

    form.addEventListener('submit', e => {
      e.preventDefault();

      const title = document.getElementById('newTitle').value.trim();
      const optionsRaw = document.getElementById('newOptions').value.trim();

      if (!title || !optionsRaw) {
        alert('Merci de remplir tous les champs.');
        return;
      }

      const options = optionsRaw.split(',').map(opt => opt.trim()).filter(opt => opt !== '');

      if (options.length === 0) {
        alert('Ajoutez au moins une option valide.');
        return;
      }

      const section = document.createElement('section');
      section.classList.add('vote-card');

      const h2 = document.createElement('h2');
      h2.textContent = title;
      section.appendChild(h2);

      const slug = title.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');

      options.forEach(opt => {
        const label = document.createElement('label');
        const radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = slug;
        radio.value = opt;
        label.appendChild(radio);
        label.append(' ' + opt);
        section.appendChild(label);
      });

      votesContainer.appendChild(section);

      form.reset();
      form.style.display = 'none';
      btn.textContent = 'Créer un vote';

      section.scrollIntoView({ behavior: 'smooth' });
    });
  </script>
</body>
</html>
