<?php
$listini = ['scuola' => 'Scuola', 'oratorio' => 'Oratorio', 'cinema' => 'Cinema'];
$tipo = filter_input(INPUT_GET, 'tipo');
if (!array_key_exists($tipo, $listini)) {
  $tipo = 'scuola';
}

$dat->table = 'dat_listino_' . $tipo;
$records = $dat->showAll('id');
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Tutti i listini</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php"><?= $common_dashboard ?></a></li>
          <li class="breadcrumb-item active" aria-current="page">Tutti i listini</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
  <div class="card shadow">
    <div class="card-header">
      <form method="GET" action="index.php" class="d-flex align-items-center gap-3">
        <input type="hidden" name="p" value="allListini">
        <label for="tipo" class="mb-0">Listino</label>
        <select class="form-select w-auto" id="tipo" name="tipo" onchange="this.form.submit()">
          <?php foreach ($listini as $k => $label) { ?>
            <option value="<?= $k ?>" <?= $k == $tipo ? 'selected' : '' ?>><?= $label ?></option>
          <?php } ?>
        </select>
        <a href="index.php?p=addListino&tipo=<?= $tipo ?>" class="btn icon icon-left btn-success shadow ms-3"><i class="bi bi-plus-circle"></i> Aggiungi prodotto</a>
      </form>
    </div>
    <div class="card-body">

      <table class="table" id="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Categoria</th>
            <th>Tabella</th>
            <th>Fascia</th>
            <th>Prezzo pubblico</th>
            <th>Prezzo Dat</th>
            <th><?= $common_actions ?></th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $records->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['categoria']) ?></td>
              <td><?= $row['tabella'] ?></td>
              <td><?= $row['fascia'] ?></td>
              <td><?= $dat->pointToComma($row['prezzo_pubblico']) ?> &euro;</td>
              <td><?= $dat->pointToComma($row['prezzo_dat']) ?> &euro;</td>
              <td class="text-nowrap">
                <a href="index.php?p=editListino&tipo=<?= $tipo ?>&idToMod=<?= $row['id'] ?>" class="btn icon btn-warning shadow">
                  <i class="bi bi-pencil-square"></i>
                </a>
                &nbsp; &nbsp;
                <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row['id'] ?>"><i class="bi bi-trash"></i></a>

                <div class="modal fade text-left" id="danger<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-danger">
                        <h5 class="modal-title white"><?= $common_modal_title_sure ?></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
                      </div>
                      <div class="modal-body">
                        Vuoi eliminare la voce <b><?= htmlspecialchars($row['categoria']) ?></b> dal listino <?= $listini[$tipo] ?>?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal"><?= $common_modal_cancel ?></button>
                        <a href="core/mngListino.php?tipo=<?= $tipo ?>&idToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1"><?= $common_modal_confirm ?></a>
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
  </div>
</section>
