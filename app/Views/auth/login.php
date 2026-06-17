<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Caisse</title>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
</head>
<body>
<div class="page-centree">
    <div class="carte-centree">
        <h1>Connexion</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="erreur"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <form method="post" action="<?= base_url('login') ?>">
            <?= csrf_field() ?>
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" placeholder="admin" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>

            <p style="font-size:12px; color:var(--texte-doux); margin-top:-8px;">
                Identifiants disponibles : <strong>admin:admin123</strong> ou <strong>caissier:caisse123</strong>
            </p>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</div>
</body>
</html>