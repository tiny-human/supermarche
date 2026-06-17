<?php $this->extend('layout/app'); ?>

<?php $this->section('content') ?>

<div class="data-card" style="margin-bottom: 1.5rem; padding: 1rem;">
    <form method="GET" action="<?= base_url('admin/demandes') ?>" style="display: flex; gap: 1rem; align-items: center;">
        <div>
            <label style="display:block; font-size:0.8rem; margin-bottom:0.2rem; color: var(--muted); font-family: var(--font-mono);">STATUT</label>
            <select name="statut" class="f-select" style="padding: 0.5rem; min-width: 150px;">
                <option value="">Tous les statuts</option>
                <option value="en_attente" <?= ($filtreStatut ?? '') == 'en_attente' ? 'selected' : '' ?>>En attente</option>
                <option value="approuvee" <?= ($filtreStatut ?? '') == 'approuvee' ? 'selected' : '' ?>>Approuvées</option>
                <option value="refusee" <?= ($filtreStatut ?? '') == 'refusee' ? 'selected' : '' ?>>Refusées</option>
            </select>
        </div>
        <div>
            <label style="display:block; font-size:0.8rem; margin-bottom:0.2rem; color: var(--muted); font-family: var(--font-mono);">DÉPARTEMENT</label>
            <select name="dept" class="f-select" style="padding: 0.5rem; min-width: 150px;">
                <option value="">Tous les départements</option>
                <?php foreach ($departements ?? [] as $d): ?>
                    <option value="<?= esc($d['id']) ?>" <?= ($filtreDept ?? '') == $d['id'] ? 'selected' : '' ?>><?= esc($d['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="margin-top: 1.3rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;"><i class="bi bi-filter"></i> Filtrer</button>
        </div>
    </form>
</div>

<!-- Liste des demandes -->
<div class="data-card">
    <div class="data-card-head">
        <h3><i class="bi bi-inbox"></i> Historique global des demandes</h3>
    </div>
    
    <?php if(empty($conges)): ?>
        <div class="empty">
            <i class="bi bi-clipboard-x"></i>
            <p>Aucune demande trouvée pour ces critères.</p>
        </div>
    <?php else: ?>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Département</th>
                    <th>Type de congé</th>
                    <th>Période</th>
                    <th>Durée</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($conges as $d): ?>
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:7px">
                                <div class="avatar av-purple" style="width:28px;height:28px;font-size:.62rem;background:#5a2d82;">
                                    <?= strtoupper(substr($d['prenom'],0,1).substr($d['nom'],0,1)) ?>
                                </div>
                                <span class="td-name" style="font-size:.84rem"><?= esc($d['prenom'] . ' ' . $d['nom']) ?></span>
                            </div>
                        </td>
                        <td><?= esc($d['departement'] ?? '—') ?></td>
                        <td><span class="type-badge t-<?= strtolower($d['type_nom'] ?? '') ?>"><?= esc($d['type_nom'] ?? '') ?></span></td>
                        <td>
                            <div style="font-size:.8rem;color:var(--text)">Du <?= date('d/m/Y', strtotime($d['date_debut'])) ?></div>
                            <div style="font-size:.7rem;color:var(--muted)">Au <?= date('d/m/Y', strtotime($d['date_fin'])) ?></div>
                        </td>
                        <td class="td-mono"><?= esc($d['nb_jours']) ?> j</td>
                        <td>
                            <?php if($d['statut'] == 'en_attente'): ?>
                                <span class="statut s-attente">en attente</span>
                            <?php elseif($d['statut'] == 'approuvee'): ?>
                                <span class="statut s-approuvee">approuvée</span>
                            <?php else: ?>
                                <span class="statut s-refusee">refusée</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
