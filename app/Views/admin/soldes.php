<?php str_repeat(" ", 0) ?>
<?= $this->extend("layout/app") ?>
<?= $this->section("content") ?>

<div class="data-card">
  <div class="data-card-head">
    <h3><i class="bi bi-sliders" style="color:var(--forest);margin-right:6px"></i>Ajustement des soldes annuels</h3>
  </div>
  <div class="flash flash-warn" style="margin:1rem 1.25rem 0">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <span style="font-size:.82rem">Toute modification manuelle est enregistrée et irréversible sans une nouvelle correction.</span>
  </div>
  <table class="tbl" style="margin-top:.5rem">
    <thead>
      <tr>
        <th>Employé</th>
        <th>Type de congé</th>
        <th>Attribués</th>
        <th>Pris</th>
        <th>Restants</th>
        <th>Ajuster (attribués)</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($soldes as $s):
      $restants = $s['jours_attribues'] - $s['jours_pris'];
      $initiales = strtoupper(substr($s['prenom'],0,1).substr($s['nom'],0,1));
    ?>
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:7px">
            <div class="avatar av-green" style="width:28px;height:28px;font-size:.62rem"><?= $initiales ?></div>
            <span class="td-name" style="font-size:.84rem"><?= esc($s['prenom'].' '.$s['nom']) ?></span>
          </div>
        </td>
        <td><span class="type-badge t-<?= strtolower($s['type_slug'] ?? '') ?>"><?= esc($s['type_nom']) ?></span></td>
        <td class="td-mono"><?= $s['jours_attribues'] ?></td>
        <td class="td-mono"><?= $s['jours_pris'] ?></td>
        <td>
          <span class="td-mono" style="color:<?= $restants <= 2 ? 'var(--danger)' : ($restants <= 5 ? 'var(--warn)' : 'var(--success)') ?>;font-weight:500">
            <?= $restants ?>
          </span>
        </td>
        <td>
          <form method="POST" action="<?= base_url('admin/soldes/ajuster') ?>" style="display:flex;align-items:center;gap:6px">
            <?= csrf_field() ?>
            <input type="hidden" name="solde_id" value="<?= $s['id'] ?>"/>
            <input type="number" name="jours_attribues" class="f-input" value="<?= $s['jours_attribues'] ?>"
                   min="0" max="365" style="width:80px;padding:5px 8px;font-size:.82rem"/>
            <button type="submit" class="btn-sm btn-edit"><i class="bi bi-check-lg"></i> OK</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div><?= $this->endSection() ?>
