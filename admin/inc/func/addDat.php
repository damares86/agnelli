<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Aggiungi fattura Dat Caffè</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Aggiungi fattura Dat Caffè
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
  <div class="card shadow">
    <div class="card-header">
      <div class="row">
        <form class="form form-horizontal upload-form" action="core/mngDat.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
          <div class="form-body">
            <div class="row">

              <div class="row">
                <div class="col-md-4  ">
                  <div class="row">

                    <div class="col-md-4">
                      <label>Anno <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-8 mb-3">
                      <div class="form-group">
                        <div class="form-check">
                          <div class="position-relative">
                            <select class="form-select" name="anno">
                              <option value="00">--</option>
                              <?php

                              for ($year = 2025; $year < 2050; $year++) {
                              ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Mese inizio <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-8 mb-3">
                      <div class="form-group">
                        <div class="form-check">
                          <div class="position-relative">
                            <select class="form-select" id="basicSelect" name="mese_inizio">
                              <option value="00">--</option>
                              <option value="01">Gennaio</option>
                              <option value="02">Febbraio</option>
                              <option value="03">Marzo</option>
                              <option value="04">Aprile</option>
                              <option value="05">Maggio</option>
                              <option value="06">Giugno</option>
                              <option value="07">Luglio</option>
                              <option value="08">Agosto</option>
                              <option value="09">settembre</option>
                              <option value="10">Ottobre</option>
                              <option value="11">Novembre</option>
                              <option value="12">Dicembre</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Mese fine <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-8 mb-3">
                      <div class="form-group">
                        <div class="form-check">
                          <div class="position-relative">
                            <select class="form-select" id="basicSelect" name="mese_fine">
                              <option value="00">--</option>
                              <option value="01">Gennaio</option>
                              <option value="02">Febbraio</option>
                              <option value="03">Marzo</option>
                              <option value="04">Aprile</option>
                              <option value="05">Maggio</option>
                              <option value="06">Giugno</option>
                              <option value="07">Luglio</option>
                              <option value="08">Agosto</option>
                              <option value="09">settembre</option>
                              <option value="10">Ottobre</option>
                              <option value="11">Novembre</option>
                              <option value="12">Dicembre</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-md-3">
                  <label>Attività <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-4 mb-3">
                  <div class="form-group">
                    <div class="form-check">
                      <div class="position-relative">
                        <select class="form-select" name="attivita">
                          <option value="00">--</option>
                          <option value="scuola">Scuola</option>
                          <option value="oratorio">Oratorio</option>
                          <option value="cinema">Cinema</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">&nbsp;</div>
              </div>

               <div class="row">
                <div class="col-md-3">
                  <label>Importo caffè salesiani <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-4 mb-3">
                  <div class="form-group">
                    <div class="form-check">
                      <div class="position-relative">
                              <input type="text" name="salesiani" class="form-control" data-parsley-required="true" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">&nbsp;</div>
              </div>

              <div class="row mt-2">
                <div class="col-md-3">
                  <label>Carica file XLSX <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="form-check mandatory">
                      <div class="position-relative">
                        <input class="form-control" type="file" id="formFile" name="xslx_file" data-parsley-required="true" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">&nbsp;</div>

                <input type="hidden" name="new" value="file">
                <div class="col-12 d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                    <?= $common_submit ?>
                  </button>
                  <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow">
                    <?= $common_reset ?>
                  </button>
                </div>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>

</section>