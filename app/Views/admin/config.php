<?php str_repeat(" ", 0) ?>
<?= $this->extend("layout/app") ?>
<?= $this->section("content") ?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">

  <!-- ═══ DÉPARTEMENTS ═══ -->
  <div>
    <div class="form-section">
      <h3><i class="bi bi-building" style="color:var(--forest);margin-right:6px"></i>Ajouter un département</h3>
      <form method="POST" action="<?= base_url('admin/departements/store') ?>">
        <?= csrf_field() ?>
        <div class="f-group">
          <label class="f-label">Nom du département <span style="color:var(--danger)">*</span></label>
          <input type="text" name="nom" class="f-input" placeholder="Ex : IT, Finance…" value="<?= esc(old('nom_dept')) ?>"/>
          <?php if (isset($validationDept) && $validationDept->hasError('nom')): ?>
            <div class="f-error"><?= $validationDept->getError('nom') ?></div>
          <?php endif; ?>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Ajouter</button>
        </div>
      </form>
    </div>

    <div class="data-card" style="margin:0">
      <div class="data-card-head"><h3>Départements</h3></div>
      <table class="tbl">
        <thead><tr><th>Nom</th><th>Employés</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($departements as $d): ?>
          <tr>
            <td class="td-name"><?= esc($d['nom']) ?></td>
            <td class="td-mono"><?= $d['nb_employes'] ?></td>
            <td>
              <div class="action-btns">
                <form method="POST" action="<?= base_url('admin/departements/delete/'.$d['id']) ?>" style="display:inline">
                  <?= csrf_field() ?>
                  <button class="btn-sm btn-del" <?= $d['nb_employes'] > 0 ? 'disabled title="Département non vide"' : '' ?>>
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ═══ TYPES DE CONGÉ ═══ -->
  <div>
    <div class="form-section">
      <h3><i class="bi bi-tags" style="color:var(--forest);margin-right:6px"></i>Ajouter un type de congé</h3>
      <form method="POST" action="<?= base_url('admin/types-conge/store') ?>">
        <?= csrf_field() ?>
        <div class="f-group">
          <label class="f-label">Nom <span style="color:var(--danger)">*</span></label>
          <input type="text" name="nom" class="f-input" placeholder="Ex : Congé annuel" value="<?= esc(old('nom_type')) ?>"/>
        </div>
        <div class="f-group">
          <label class="f-label">Slug (code interne) <span style="color:var(--danger)">*</span></label>
          <input type="text" name="slug" class="f-input" placeholder="annuel" value="<?= esc(old('slug')) ?>"/>
          <div class="f-hint">Minuscules, sans espaces. Ex : annuel, maladie, special</div>
        </div>
        <div class="f-group">
          <label class="f-label">Jours attribués par défaut <span style="color:var(--danger)">*</span></label>
          <input type="number" name="jours_par_defaut" class="f-input" placeholder="30" min="0" value="<?= esc(old('jours_par_defaut')) ?>"/>
        </div>
        <div class="f-group">
          <label class="f-label">Description</label>
          <textarea name="description" class="f-textarea" rows="2" placeholder="Description optionnelle…"><?= esc(old('description_type')) ?></textarea>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Ajouter</button>
        </div>
      </form>
    </div>

    <div class="data-card" style="margin:0">
      <div class="data-card-head"><h3>Types de congé</h3></div>
      <table class="tbl">
        <thead><tr><th>Nom</th><th>Slug</th><th>Jours / défaut</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($typesConge as $t): ?>
          <tr>
            <td class="td-name"><?= esc($t['nom']) ?></td>
            <td class="td-mono"><?= esc($t['slug']) ?></td>
            <td class="td-mono"><?= $t['jours_par_defaut'] ?> j</td>
            <td>
              <div class="action-btns">
                <form method="POST" action="<?= base_url('admin/types-conge/delete/'.$t['id']) ?>" style="display:inline">
                  <?= csrf_field() ?>
                  <button class="btn-sm btn-del" onclick="return confirm('Supprimer ce type ?')">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div><?= $this->endSection() ?>
