<?php
require 'inc/header.php';
require 'inc/sidebar.php';

$page_name = 'rubrica';
?>

<div class="page-content-wrapper">
    <div class="pt-3"></div>
    <div class="container">
        <h3 class="text-center">Rubrica Agnelli</h3>
        <h5 class="text-center">Seleziona la categoria di contatti o cerca direttamente</h5>

        <!-- SELECT -->
        <select class="form-select mb-3" id="categoryFilter">
            <option value="">Tutte le categorie</option>
        </select>
        <input type="text" id="globalSearch" class="form-control mb-3" placeholder="Cerca contatto...">
        <!-- DESKTOP TABLE -->
        <div class="card d-none d-lg-block">
            <div class="card-body">
                <table class="table w-100" id="dataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nome</th>
                            <th>Categoria</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- MOBILE CARDS -->
        <div id="mobileCards" class="d-lg-none"></div>

    </div>
</div>

<?php
require 'inc/nav.php';
?>

<!-- JS -->
<script src="js/rubrica.js"></script>

<style>
    /* accordion full width */
    .child-row-full td {
        padding: 0 !important;
    }

    .child-row-full .accordion {
        width: 100%;
    }
</style>

<?php
require 'inc/footer.php';
?>