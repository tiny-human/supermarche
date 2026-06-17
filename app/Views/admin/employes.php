<?php str_repeat(" ", 0) ?>
<?= $this->extend("layout/app") ?>
<?= $this->section("content") ?>

<!-- Formulaire ajout/édition -->
<div class="form-section">
  <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>
    <?= isset($employe) ? 'Modifier l\'employé' : 'Ajouter un employé' ?>
  </h3>
  <form method="POST" action="<?= isset($employe) ? base_url('admin/employes/update/'.$employe['id']) : base_url('admin/employes/store') ?>">
    <?= csrf_field() ?>
    <div class="form-grid-2">
      <div class="f-group">
        <label class="f-label">Prénom <span style="color:var(--danger)">*</span></label>
        <input type="text" name="prenom" class="f-input" placeholder="Jean" value="<?= esc(old('prenom', $employe['prenom'] ?? '')) ?>"/>
        <?php if (isset($validation) && $validation->hasError('prenom')): ?>
          <div class="f-error"><?= $validation->getError('prenom') ?></div>
        <?php endif; ?>
      </div>
      <div class="f-group">
        <label class="f-label">Nom <span style="color:var(--danger)">*</span></label>
        <input type="text" name="nom" class="f-input" placeholder="Rakoto" value="<?= esc(old('nom', $employe['nom'] ?? '')) ?>"/>
        <?php if (isset($validation) && $validation->hasError('nom')): ?>
          <div class="f-error"><?= $validation->getError('nom') ?></div>
        <?php endif; ?>
      </div>
      <div class="f-group">
        <label class="f-label">Email <span style="color:var(--danger)">*</span></label>
        <input type="email" name="email" class="f-input" placeholder="jean.rakoto@techmada.mg" value="<?= esc(old('email', $employe['email'] ?? '')) ?>"/>
        <?php if (isset($validation) && $validation->hasError('email')): ?>
          <div class="f-error"><?= $validation->getError('email') ?></div>
        <?php endif; ?>
      </div>
      <?php if (!isset($employe)): ?>
      <div class="f-group">
        <label class="f-label">Mot de passe initial <span style="color:var(--danger)">*</span></label>
        <input type="password" name="password" class="f-input" placeholder="Min. 6 caractères"/>
        <?php if (isset($validation) && $validation->hasError('password')): ?>
          <div class="f-error"><?= $validation->getError('password') ?></div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <div class="f-group">
        <label class="f-label">Département <span style="color:var(--danger)">*</span></label>
        <select name="departement_id" class="f-select">
          <?php foreach ($departements as $d): ?>
            <option value="<?= $d['id'] ?>" <?= old('departement_id', $employe['departement_id'] ?? '') == $d['id'] ? 'selected' : '' ?>>
              <?= esc($d['nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="f-group">
        <label class="f-label">Rôle <span style="color:var(--danger)">*</span></label>
        <select name="role" class="f-select">
          <?php foreach (['employe'=>'Employé','rh'=>'Responsable RH','admin'=>'Administrateur'] as $val => $label): ?>
            <option value="<?= $val ?>" <?= old('role', $employe['role'] ?? 'employe') === $val ? 'selected' : '' ?>>
              <?= $label ?>
            </option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($validation) && $validation->hasError('role')): ?>
          <div class="f-error"><?= $validation->getError('role') ?></div>
        <?php endif; ?>
      </div>
      <div class="f-group">
        <label class="f-label">Date d'embauche</label>
        <input type="date" name="date_embauche" class="f-input" value="<?= esc(old('date_embauche', $employe['date_embauche'] ?? date('Y-m-d'))) ?>"/>
      </div>
    </div>

    <div class="flash flash-info" style="margin-bottom:1rem">
      <i class="bi bi-info-circle-fill"></i>
      <span style="font-size:.82rem">Les soldes seront initialisés automatiquement selon les types de congé configurés.</span>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-forest">
        <i class="bi bi-<?= isset($employe) ? 'save' : 'plus' ?>"></i>
        <?= isset($employe) ? 'Enregistrer' : 'Créer l\'employé' ?>
      </button>
      <?php if (isset($employe)): ?>
        <a href="<?= base_url('admin/employes') ?>" class="btn-secondary"><i class="bi bi-arrow-left"></i> Annuler</a>
      <?php else: ?>
        <button type="reset" class="btn-secondary">Réinitialiser</button>
      <?php endif; ?>
    </div>
  </form>
</div>

<!-- Liste employés -->
<div class="data-card">
  <div class="data-card-head">
    <h3>Tous les employés</h3>
    <form method="GET" style="display:flex;gap:6px">
      <input type="text" name="search" class="f-input" placeholder="Rechercher..."
             value="<?= esc($search ?? '') ?>" style="width:200px;padding:6px 10px;font-size:.8rem"/>
      <select name="dept" class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto" onchange="this.form.submit()">
        <option value="">Tous les depts</option>
        <?php foreach ($departements as $d): ?>
          <option value="<?= $d['id'] ?>" <?= ($filtreDept ?? '') == $d['id'] ? 'selected' : '' ?>><?= esc($d['nom']) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn-forest" style="padding:6px 12px;font-size:.8rem">Filtrer</button>
    </form>
  </div>

  <table class="tbl">
    <thead>
      <tr><th>Employé</th><th>Département</th><th>Rôle</th><th>Embauche</th><th>Statut</th><th>Solde annuel</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($employes as $e):
      $initiales = strtoupper(substr($e['prenom'],0,1).substr($e['nom'],0,1));
      $avCls = match($e['role']) {
        'admin' => 'style="background:#5a2d82"',
        'rh'    => 'av-blue',
        default => 'av-green',
      };
    ?>
      <tr <?= $e['actif'] ? '' : 'style="opacity:.5"' ?>>
        <td>
          <div class="profile-row">
            <div class="avatar <?= is_string($avCls)&&str_starts_with($avCls,'av-') ? $avCls : '' ?>"
                 <?= is_string($avCls)&&str_starts_with($avCls,'style') ? $avCls : '' ?>
                 style="width:32px;height:32px;font-size:.68rem"><?= $initiales ?></div>
            <div class="profile-info">
              <div class="pname"><?= esc($e['prenom'].' '.$e['nom']) ?></div>
              <div class="pdept"><?= esc($e['email']) ?></div>
            </div>
          </div>
        </td>
        <td class="td-muted"><?= esc($e['departement']) ?></td>
        <td><span class="type-badge <?= $e['role']==='rh' ? 't-maladie' : '' ?>" style="<?= $e['role']==='admin' ? 'background:#f0e8fb;color:#5a2d82' : ($e['role']==='employe' ? 'background:#f1efe8;color:#444441' : '') ?>">
          <?= esc($e['role']) ?>
        </span></td>
        <td class="td-muted td-mono" style="font-size:.78rem"><?= esc($e['date_embauche'] ?? '—') ?></td>
        <td>
          <span class="statut <?= $e['actif'] ? 's-approuvee' : 's-annulee' ?>" style="font-size:.68rem">
            <?= $e['actif'] ? 'actif' : 'inactif' ?>
          </span>
        </td>
        <td>
          <span style="font-family:'DM Mono',monospace;font-size:.82rem;color:<?= $e['actif'] ? 'var(--forest)' : 'var(--muted)' ?>">
            <?= $e['solde_annuel'] ?? '—' ?>
          </span>
        </td>
        <td>
          <div class="action-btns">
            <a href="<?= base_url('admin/employes/edit/'.$e['id']) ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a>
            <?php if ($e['actif']): ?>
              <form method="POST" action="<?= base_url('admin/employes/desactiver/'.$e['id']) ?>" style="display:inline">
                <?= csrf_field() ?>
                <button class="btn-sm btn-del" onclick="return confirm('Désactiver cet employé ?')">
                  <i class="bi bi-slash-circle"></i>
                </button>
              </form>
            <?php else: ?>
              <form method="POST" action="<?= base_url('admin/employes/reactiver/'.$e['id']) ?>" style="display:inline">
                <?= csrf_field() ?>
                <button class="btn-sm btn-view"><i class="bi bi-arrow-counterclockwise"></i> Réactiver</button>
              </form>
            <?php endif; ?>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div><?= $this->endSection() ?>
