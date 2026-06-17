<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie des achats</title>
</head>
<body>

<h1>Saisie des achats</h1>

<div class="info">
    <strong>Caisse :</strong> <?= session()->get('caisse_id') ?>
</div>

<form id="form_achat" action="<?= base_url('achat/cloturer') ?>" method="post">
    <?= csrf_field() ?>

    <select name="produit_id" id="produit_id">
        <?php foreach ($produits as $produit): ?>
            <option value="<?= $produit['id'] ?>"
                    data-designation="<?= $produit['designation'] ?>"
                    data-prix="<?= $produit['prix'] ?>">
                <?= $produit['designation'] ?> - <?= $produit['prix'] ?> Ar
            </option>
        <?php endforeach; ?>
    </select>

    <input type="number" name="quantite" id="quantite" placeholder="Quantité" min="1" value="1">

    <button type="button" onclick="ajouterLigne()">Ajouter</button>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="tbody"></tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong id="total">0</strong> Ar</td>
            </tr>
        </tfoot>
    </table>

    <input type="hidden" name="lignes" id="input_lignes">
    <button type="submit">Clôturer</button>

</form>

<script>
    const lignes = [];

    function ajouterLigne() {
        const select      = document.getElementById('produit_id');
        const option      = select.options[select.selectedIndex];
        const produit_id  = option.value;
        const designation = option.dataset.designation;
        const prix        = parseFloat(option.dataset.prix);
        const qte         = parseInt(document.getElementById('quantite').value);
        const montant     = prix * qte;

        lignes.push({ produit_id, designation, prix, quantite: qte, montant });

        const tr = document.createElement('tr');
        const index = lignes.length - 1;
        tr.innerHTML = `
            <td>${designation}</td>
            <td>${qte}</td>
            <td>${prix} Ar</td>
            <td>${montant} Ar</td>
        `;
        document.getElementById('tbody').appendChild(tr);

        majTotal();
    }

    function majTotal() {
        const total = lignes.reduce((sum, l) => sum + l.montant, 0);
        document.getElementById('total').textContent = total;
    }

    // Avant soumission, on met les lignes en JSON dans le champ caché
    document.getElementById('form_achat').addEventListener('submit', function(e) {
        if (lignes.length === 0) {
            e.preventDefault();
            alert('Ajoutez au moins une ligne.');
            return;
        }
        document.getElementById('input_lignes').value = JSON.stringify(lignes);
    });
</script>

</body>
</html>