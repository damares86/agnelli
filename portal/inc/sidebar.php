<button id="burger-menu" class="burger-menu">
  ☰
</button>
<div id="side_luna" class="">
  <div class="sidebar_luna sidebar-wrapper_luna shadow">
    <div class="sidebar-logo">
      <!-- <a href="index.php">-->
      <img src="../assets/img/logo_agnelli_scritta.png" alt="Logo" srcset="" />
      <!--</a>-->
      <a href="../" class="btn icon btn-primary shadow m-3 px-3 text-white">
        <i class="bi bi-arrow-left-circle"></i> &nbsp; Torna all'app
      </a>
    </div>
    <?php
    if ($check_user) {
    ?>
      <div class="col-12 mb-3 border">
        <div class="d-flex align-items-center">
          <div class="dropdown">
            <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle border-0" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="text">
                <h6 class="user-dropdown-name"><?= $_SESSION['luna_username'] ?></h6>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
              <li><a class="dropdown-item border-0" href="../admin/core/luna_logout.php"><?= $common_logout ?></a></li>
            </ul>
          </div>

        </div>
      </div>
    <?php
    }
    ?>
    <style>
      li.active>a {
        font-weight: bold;
      }
    </style>

    <ul class="list-unstyled">
      <?php
      $active = "";
      ?>

      <?php

      $pages_json = file_get_contents('../admin/inc/luna_pages/pages_' . $row4['id'] . '.json');
      $pages_data = json_decode($pages_json, true);


      foreach ($pages_data['parent'] as $parent) {
        $luna->table = 'luna_pages_' . $prod_id;
        $luna->id = $parent;
        $parent_stmt = $luna->showAllWhere('id', ['id']);
        $parent_row = $parent_stmt->fetch(PDO::FETCH_ASSOC);
        extract($parent_row);

        $title = $parent_row['title'];

        $hasSub = false;
        $active = "";
        $nochild = "";
        $link = "?prod=" . $prod_id . "&parent=1&page=" . $parent_row['id'] . "";

        foreach ($pages_data['child'] as $child) {

          if ($child['parent_id'] == $parent_row['id']) {
            if (is_array($child['id'])) {
              $hasSub = true;
              // $link = $link.'#';
            } else {
              $nochild = "nochild";
            }
          }
        }
        if ($check_parent == 1) {
          if ($page_id == $parent_row['id']) {
            $active = "active";
          }
        }

      ?>
        <li class="d-flex align-items-center <?= $nochild ?> <?= $active ?>" data-parent-id="<?= $parent_row['id'] ?>">

          <a href="manual.php<?= $link ?>"><?= $title ?></a>
          <?php
          if ($hasSub) {
          ?>
            <span class="toggle-submenu">+</span>
          <?php
          }
          ?>
        </li>
        <?php
        if ($hasSub) {
        ?>
          <ul class="submenu list-unstyled">
            <?php
            foreach ($pages_data['child'] as $child) {

              if ($child['parent_id'] == $parent_row['id']) {

                foreach ($child['id'] as $item) {

                  $luna->table = 'luna_pages_' . $prod_id;
                  $luna->id = $item;
                  $child_stmt = $luna->showAllWhere('id', ['id']);
                  $child_row = $child_stmt->fetch(PDO::FETCH_ASSOC);
                  extract($child_row);

                  $title_child = $child_row['title'];
                  $active1 = "";

                  $link_sub = "?prod=" . $prod_id . "&page=" . $child_row['id'] . "";
                  if ($page_id == $child_row['id']) {
                    $active1 = "active";

                    foreach ($pages_data['paragraph'] as $paragraph) {

                      if ($paragraph['child_id'] == $child_row['id']) {
                        if (is_array($paragraph['id'])) {
                          $label = 'hasParagraph_' . $child_row['id'];
                          $$label = true;
                        }
                      }
                    }
                  }
            ?>
                  <li class="<?= $active1 ?>"><a href="manual.php<?= $link_sub ?>" data-parent-id="<?= $parent_row['id'] ?>"><?= $title_child ?></a></li>
            <?php
                }
              }
            }
            ?>
          </ul>

      <?php
        }
      }
      ?>
    </ul>

  </div>
</div>

<script>
  $(document).ready(function() {
    const currentPage = <?= $page_id ?>;
    const parentPage = <?= $check_parent ?>;
    let parentOfChild = null;

    function openSubmenu($submenu) {
      $submenu.addClass('active').show(); // show senza animazione
      $submenu.prev('li').find('.toggle-submenu').text('-');
    }

    function closeSubmenu($submenu) {
      $submenu.removeClass('active').slideUp();
      $submenu.prev('li').find('.toggle-submenu').text('+');
    }

    // Apri submenu se uno dei figli è attivo
    $('a[data-parent-id]').each(function() {
      const $this = $(this);
      const parentId = $this.data('parent-id');

      if (parentId == parentPage || parentId == currentPage) {
        const $submenu = $this.closest('ul.submenu');
        openSubmenu($submenu);

        if (parentId == currentPage) {
          parentOfChild = parentId;
        }
      }
    });

    // Apri anche il parent se la pagina corrente è un child
    if (parentOfChild !== null) {
      $('a[data-parent-id="' + parentOfChild + '"]').each(function() {
        const $submenu = $(this).closest('ul.submenu');
        openSubmenu($submenu);
      });
    }

    // Aggiungi .active anche al parent se un figlio è attivo
    $('.submenu').each(function() {
      if ($(this).find('li.active').length > 0) {
        $(this).prev('li').addClass('active');
        openSubmenu($(this));
      }
    });

    // Gestione del click su +
    $('.toggle-submenu').on('click', function(e) {
      e.preventDefault();
      const $submenu = $(this).closest('li').next('.submenu');

      if ($submenu.hasClass('active')) {
        closeSubmenu($submenu);
        $(this).text('+');
      } else {
        openSubmenu($submenu);
        $(this).text('-');
      }
    });

    // Burger menu
    $('#burger-menu').on('click', function() {
      $('#side_luna').toggleClass('active');
    });
  });
</script>