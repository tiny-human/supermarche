<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir une caisse</title>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
</head>
<body>
<div class="page-centree">
    <div class="carte-centree">
        <h1>Choisir une caisse</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="erreur"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <form action="<?= base_url('caisse/valider') ?>" method="post">
            <?= csrf_field() ?>
            <label for="caisse_id">Numéro de caisse</label>
            <select name="caisse_id" id="caisse_id">
                <?php if (!empty($caisses)): ?>
                    <?php foreach ($caisses as $caisse): ?>
                        <option value="<?= esc($caisse['id']) ?>">
                            Caisse n° <?= esc($caisse['numero']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Aucune caisse disponible</option>
                <?php endif; ?>
            </select>
            <button type="submit">Valider</button>
        </form>
    </div>
</div>
</body>
</html>