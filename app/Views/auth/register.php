<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte — Caisse</title>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
</head>
<body>
<div class="page-centree">
    <div class="carte-centree">
        <h1>Créer un compte</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="erreur"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <form method="post" action="<?= base_url('register') ?>">
            <?= csrf_field() ?>
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" placeholder="Votre nom" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>

            <button type="submit">S'inscrire</button>
        </form>

        <p style="text-align:center; margin-top:16px; font-size:13px; color:var(--texte-doux)">
            Déjà inscrit ? <a href="<?= base_url('login') ?>">Se connecter</a>
        </p>
    </div>
</div>
</body>
</html>