<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie des achats</title>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
</head>
<body>
<div class="container">

    <h1>Saisie des achats</h1>

    <div class="info">
        <strong>Caisse :</strong> <?= session()->get('caisse_numero') ?>
    </div>

    <div class="card">
        <form id="form_achat" action="<?= base_url('achat/cloturer') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-row">
                <div>
                    <label for="produit_id">Produit</label>
                    <select name="produit_id" id="produit_id">
                        <?php foreach ($produits as $produit): ?>
                            <option value="<?= $produit['id'] ?>"
                                    data-designation="<?= esc($produit['designation']) ?>"
                                    data-prix="<?= $produit['prix'] ?>">
                                <?= esc($produit['designation']) ?> — <?= $produit['prix'] ?> Ar
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="quantite">Quantité</label>
                    <input type="number" id="quantite" min="1" value="1">
                </div>
                <div style="align-self: flex-end">
                    <button type="button" onclick="ajouterLigne()">Ajouter</button>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unit.</th>
                        <th>Montant</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2"><strong id="total">0</strong> Ar</td>
                    </tr>
                </tfoot>
            </table>

            <input type="hidden" name="lignes" id="input_lignes">
            <button type="submit">Clôturer l'achat</button>

        </form>
    </div>
</div>

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

        const index = lignes.length;
        lignes.push({ produit_id, designation, prix, quantite: qte, montant });

        const tr = document.createElement('tr');
        tr.id = 'ligne-' + index;
        tr.innerHTML = `
            <td>${designation}</td>
            <td>${qte}</td>
            <td>${prix.toLocaleString()} Ar</td>
            <td>${montant.toLocaleString()} Ar</td>
            <td>
                <button type="button" class="btn-danger"
                        onclick="supprimerLigne(${index})">
                    Supprimer
                </button>
            </td>
        `;
        document.getElementById('tbody').appendChild(tr);
        majTotal();
    }

    function supprimerLigne(index) {
        lignes[index] = null;
        const tr = document.getElementById('ligne-' + index);
        if (tr) tr.remove();
        majTotal();
    }

    function majTotal() {
        const total = lignes
            .filter(l => l !== null)
            .reduce((sum, l) => sum + l.montant, 0);
        document.getElementById('total').textContent = total.toLocaleString();
    }

    document.getElementById('form_achat').addEventListener('submit', function(e) {
        const valides = lignes.filter(l => l !== null);
        if (valides.length === 0) {
            e.preventDefault();
            alert('Ajoutez au moins une ligne avant de clôturer.');
            return;
        }
        document.getElementById('input_lignes').value = JSON.stringify(valides);
    });
</script>

</body>
</html>