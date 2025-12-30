<button id="burger-menu" class="burger-menu">
☰
</button>
<div id="side_luna" class="">
  <div class="sidebar_luna sidebar-wrapper_luna shadow">
    <div class="sidebar-logo">
      <a href="index.php">
        <img src="assets/img/logo/luna_logo.png" alt="Logo" srcset="" />
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
        $link = "?prod=" . $prod_id . "&parent=1&page=" . $parent_row['id'] . "";

        foreach ($pages_data['child'] as $child) {

          if ($child['parent_id'] == $parent_row['id']) {
            if (is_array($child['id'])) {
              $hasSub = true;
              // $link = $link.'#';
            }
          }
        }

        if ($page_id == $parent_row['id'] || $check_parent == 1) {
          $active = "active";
        }
      ?>
        <li class="d-flex align-items-center <?= $active ?>">
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
  var currentPage = <?= $page_id ?>;
  var parentPage = <?= $check_parent ?>;
  var parentOfChild = null;

  // Funzione per aprire il submenu
  function openSubmenu($submenu) {
    $submenu.addClass('active').slideDown();
    $submenu.prev('li').find('.toggle-submenu').text('-');
  }

  // Apri i submenu dei parent attivi
  $('a[data-parent-id]').each(function() {
    var $this = $(this);
    var parentId = $this.data('parent-id');

    // Controllo per parentPage e currentPage
    if (parentId == parentPage || parentId == currentPage) {
      var $submenu = $this.closest('.submenu');
      openSubmenu($submenu);

      // Se la pagina corrente è un child, memorizza il parent
      if (parentId == currentPage) {
        parentOfChild = $this.data('parent-id');
      }
    }
  });

  // Se la pagina corrente è un child, apri anche il parent e il relativo submenu
  if (parentOfChild !== null) {
    $('a[data-parent-id="' + parentOfChild + '"]').each(function() {
      var $submenu = $(this).closest('.submenu');
      openSubmenu($submenu);
    });
  }

  // Aggiungi la classe active anche al parent del submenu
  $('.submenu').each(function() {
    if ($(this).find('li.active').length > 0) {
      $(this).prev('li').addClass('active');
      openSubmenu($(this));
    }
  });

  // Gestione del click sul toggle del submenu
  $('.toggle-submenu').on('click', function(e) {
    e.preventDefault();
    var $submenu = $(this).closest('li').next('.submenu');
    $submenu.slideToggle();
    $(this).text(function(_, text) {
      return text === '+' ? '-' : '+';
    });
  });
});


  // Gestione del click sul burger menu
  $('#burger-menu').on('click', function() {
    $('#side_luna').toggleClass('active');
  });
 
</script>