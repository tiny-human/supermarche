<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection de la Caisse</title>
</head>
<body>
    <h1>Saisir le numéro de caisse</h1>
    <form action="/caisse/valider" method="post">
        <?= csrf_field() ?>
        <!-- liste deroulante des caisses -->
        <label for="caisse">Choisir une caisse :</label>
        <select name="caisse" id="caisse">
            <?php if (isset($caisses) && !empty($caisses)): ?>
                <?php foreach ($caisses as $caisse): ?>
                    <option value="<?= esc($caisse['id']) ?>">Caisse n°<?= esc($caisse['numero']) ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">Aucune caisse disponible</option>
            <?php endif; ?>
        </select>
        <button type="submit">Valider</button>
    </form>
</body>
</html>