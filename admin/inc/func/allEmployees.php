<?php
$employee->table = 'employee';
$list = $employee->allEmployees();
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Dipendenti</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php"><?= $common_dashboard ?></a></li>
          <li class="breadcrumb-item active" aria-current="page">Dipendenti</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
  <div class="card shadow">
    <div class="card-header">
      Anagrafica dipendenti e orario settimanale &nbsp; &nbsp;
      <a href="index.php?p=addEmployee" class="btn icon icon-left btn-success shadow"><i class="bi bi-plus-circle"></i> Aggiungi dipendente</a>
      <a href="index.php?p=importTimbrature" class="btn icon icon-left btn-primary shadow"><i class="bi bi-upload"></i> Carica timbrature</a>
    </div>
    <div class="card-body">

      <form action="core/mngEmployee.php" method="POST">
        <input type="hidden" name="operation" value="bulkHours">

        <div class="table-responsive">
          <table class="table table-hover" id="table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Badge</th>
                <th class="text-center">Lun</th>
                <th class="text-center">Mar</th>
                <th class="text-center">Mer</th>
                <th class="text-center">Gio</th>
                <th class="text-center">Ven</th>
                <!-- <th class="text-center">Tot. sett.</th> -->
                <th class="text-center">Stato</th>
                <th><?= $common_actions ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($list as $row) { ?>
                <tr>
                  <td><?= htmlspecialchars($row['name']) ?></td>
                  <td><?= htmlspecialchars($row['badge']) ?></td>
                  <?php foreach (['mon' => 'h_mon', 'tue' => 'h_tue', 'wed' => 'h_wed', 'thu' => 'h_thu', 'fri' => 'h_fri'] as $k => $f) { ?>
                    <td style="max-width:90px">
                      <input type="number" step="0.25" min="0" max="24" class="form-control form-control-sm text-center"
                        name="h[<?= $row['id'] ?>][<?= $k ?>]" value="<?= rtrim(rtrim(number_format((float)$row[$f], 2, '.', ''), '0'), '.') ?: 0 ?>">
                    </td>
                  <?php } ?>
                  <!-- <td class="text-center fw-bold"><?= rtrim(rtrim(number_format(Employee::weekTotal($row), 2, ',', ''), '0'), ',') ?></td> -->
                  <td class="text-center">
                    <?php if ($row['active']) { ?>
                      <span class="badge bg-success">Attivo</span>
                    <?php } else { ?>
                      <span class="badge bg-secondary">Non attivo</span>
                    <?php } ?>
                  </td>
                  <td class="text-nowrap">
                    <a href="index.php?p=editEmployee&idToMod=<?= $row['id'] ?>" class="btn icon btn-warning shadow"><i class="bi bi-pencil-square"></i></a>
                    &nbsp;
                    <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row['id'] ?>"><i class="bi bi-trash"></i></a>

                    <div class="modal fade text-left" id="danger<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-danger">
                            <h5 class="modal-title white"><?= $common_modal_title_sure ?></h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
                          </div>
                          <div class="modal-body">
                            Eliminando il dipendente <b><?= htmlspecialchars($row['name']) ?></b> le sue timbrature resteranno in archivio ma non saranno più associate.
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal"><?= $common_modal_cancel ?></button>
                            <a href="core/mngEmployee.php?idToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1"><?= $common_modal_confirm ?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <?php if (!empty($list)) { ?>
          <button type="submit" class="btn btn-primary shadow mt-3"><i class="bi bi-save"></i> Salva orari</button>
          <small class="text-muted ms-2">Le ore si inseriscono in formato decimale (es. 6.5 = 6 ore e 30 minuti). 0 = giorno non lavorativo.</small>
        <?php } else { ?>
          <p class="text-muted mb-0">Nessun dipendente in anagrafica. Aggiungine uno oppure carica un file di timbrature: i nominativi trovati verranno creati automaticamente.</p>
        <?php } ?>
      </form>

    </div>
  </div>
</section>
