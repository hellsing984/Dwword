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
    <form id="emailForm">
      <label for="email">Ton e-mail :</label>
      <input type="email" name="email" id="email" required />
      <button type="submit">Valider</button>
    </form>
  </header>

  <main class="container" id="voteArea" style="display:none;">

    <?php
    // Déclaration mise à jour des votes
    $votes = [
    'apprenant' => [
        'titre' => 'A - Apprenant🧑🎓',
        'options' => [
            [
                'texte' => '😀Le radieu - Prix destiné à l\'élève qui éblouit en passant.',
                'images' => ['images/théo.png', 'images/jb.png', 'images/kevin.png', 'images/sylvain.png', 'images/romain.png', 'images/nadima.png']
            ],
            [
                'texte' => '😇L’ami de tous - Prix destiné à l’élève le plus social.',
                'images' => ['images/théo.png','images/JB.png','images/kevin.png','images/Sylvain.png','images/Romain.png','images/nadima.png']
            ],
            [
                'texte' => '🥳Le fêtard - Prix destiné à l’élève le plus festif.',
                'images' => ['images/théo.png','images/JB.png','images/kevin.png','images/Sylvain.png','images/Romain.png','images/nadima.png']
            ],
            [
                'texte' => '🥵Le Titan du Travail - Prix destiné à l’élève le plus bosseur et sérieux.',
                'images' => ['images/théo.png','images/JB.png','images/kevin.png','images/Sylvain.png','images/Romain.png','images/nadima.png']
            ],
            [
                'texte' => '🤩Le Designer - Prix destiné à lʼélève qui adore le design et le front.',
                'images' => ['images/théo.png','images/JB.png','images/kevin.png','images/Sylvain.png','images/Romain.png','images/nadima.png']
            ],
            [
                'texte' => '🤓Le Codeur émérite - Prix destiné à l’élève qui sʼest marié avec le code.',
                'images' => ['images/théo.png','images/JB.png','images/kevin.png','images/Sylvain.png','images/Romain.png','images/nadima.png']
            ],
            [
                'texte' => '🤣La Fusée de l’Animation - Prix destiné à l’élève le plus fun, jamais à court de blague.',
                'images' => ['images/théo.png','images/JB.png','images/kevin.png','images/Sylvain.png','images/Romain.png','images/nadima.png']
            ],
            [
                'texte' => '😠Le râleur ou grincheux - Prix destiné à l’élève le plus frustré et grognon.',
                'images' => ['images/théo.png','images/JB.png','images/kevin.png','images/Sylvain.png','images/Romain.png','images/nadima.png']
            ],
            [
                'texte' => '😌Le Défenseur de la Patience - Prix destiné au prof qui fait preuve d\'une patience exceptionnelle.',
                'images' => ['images/luc.png','images/christophe.png','images/laetitia.png','images/brenda.png','images/cedric.png',]
            ],
            [
                'texte' => '🤪Le Comique Magistral - Prix destiné au prof qui apporte la joie et le rire en classe.',
                'images' => ['images/luc.png','images/christophe.png','images/laetitia.png','images/brenda.png','images/cedric.png',]
            ],
            [
                'texte' => '😵L’étourdi - Prix destiné au prof maladroit ou distrait.',
                'images' => ['images/luc.png','images/christophe.png','images/laetitia.png','images/brenda.png','images/cedric.png',]
            ]
        ]
    ]
];

    foreach ($votes as $type => $data):
    ?>
    <section class="vote-card">
      <h2><?php echo htmlspecialchars($data['titre']); ?></h2>

      <form method="post" action="vote.php">
        <input type="hidden" name="vote_type" value="<?php echo htmlspecialchars($type); ?>">

        <?php foreach ($data['options'] as $index => $opt): ?>
          <div class="vote-block">
            <p class="vote-text"><?php echo htmlspecialchars($opt['texte']); ?></p>
            <div class="vote-images">
              <?php foreach ($opt['images'] as $i => $img): ?>
                <?php
                  $radioId = 'radio_' . $index . '_' . $i;
                  $radioName = 'choice_' . $index; // nom choisi ici
                  $value = $opt['texte'] . '|' . basename($img);
                ?>
                <input type="radio" name="<?php echo $radioName; ?>" id="<?php echo $radioId; ?>" value="<?php echo htmlspecialchars($value); ?>" required hidden>
                <label for="<?php echo $radioId; ?>">
                  <img src="<?php echo htmlspecialchars($img); ?>" alt="Choix" class="vote-avatar" />
                </label>
              <?php endforeach; ?>
            </div>
          </div>
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
    const emailForm = document.getElementById('emailForm');
    const voteArea = document.getElementById('voteArea');

    emailForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const emailInput = document.getElementById('email');
      const email = emailInput.value.trim();

      if (!email || !validateEmail(email)) {
        alert("Veuillez entrer un e-mail valide.");
        return;
      }

      // Stocke l’email dans sessionStorage
      sessionStorage.setItem('user_email', email);

      // Affiche la zone de vote
      voteArea.style.display = 'block';

      // Désactive le formulaire d’email
      emailInput.disabled = true;
      emailForm.querySelector('button').disabled = true;

      // Injecte l’email dans tous les formulaires de vote
      document.querySelectorAll('form[action="vote.php"]').forEach(form => {
        let hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'email';
        hidden.value = email;
        form.appendChild(hidden);
      });
    });

    function validateEmail(email) {
      return /\S+@\S+\.\S+/.test(email);
    }
  </script>
</body>
</html>
