$(document).ready(function () {

    // 🔸 carica categorie
    $.getJSON('ajax/get_categories.php', function (data) {
        data.forEach(cat => {
            $('#categoryFilter').append(
                `<option value="${cat.id}">${cat.name}</option>`
            );
        });
    });

    // 🔸 render CARD mobile
function renderCards(data) {
    let container = $('#mobileCards');
    container.empty();

    let search = $('#globalSearch').val()?.toLowerCase() || '';

    data.forEach(d => {

        let text = `
            ${d.name}
            ${d.category_name}
            ${d.company}
            ${d.number}
            ${d.email ?? ''}
            ${d.address ?? ''}
            ${d.notes ?? ''}
        `.toLowerCase();

        // filtro
        if (search && !text.includes(search)) {
            return;
        }

        let card = `
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">${d.name}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">${d.category_name}</h6>

                    <p class="mb-1"><strong>Azienda:</strong> ${d.company}</p>
                    <p class="mb-1"><strong>Telefono:</strong> <a href="tel:${d.number}">${d.number}</a></p>

                    ${d.email ? `<p class="mb-1"><strong>Email:</strong> ${d.email}</p>` : ''}
                    ${d.address ? `<p class="mb-1"><strong>Indirizzo:</strong> ${d.address}</p>` : ''}
                    ${d.notes ? `<p class="mb-1"><strong>Note:</strong> ${d.notes}</p>` : ''}
                </div>
            </div>
        `;
        container.append(card);
    });
}

    // 🔸 DataTable desktop
    var table = $('#dataTable').DataTable({
        ajax: {
            url: 'ajax/get_data.php',
            data: function (d) {
                d.category = $('#categoryFilter').val();
            },
            dataSrc: function (json) {

                // aggiorna mobile
                renderCards(json.data);

                return json.data;
            }
        },
        columns: [
            {
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: '<button class="btn btn-sm btn-primary">+</button>'
            },
            { data: 'name' },
            { data: 'category_name' }
        ],
        order: [[1, 'asc']]
    });
    
    $('#globalSearch').on('keyup', function () {
    table.search(this.value).draw();

    // aggiorna anche mobile (senza chiamata ajax)
    renderCards(table.ajax.json().data);
    });

    // 🔸 filtro
    $('#categoryFilter').on('change', function () {
        table.ajax.reload();
    });

    // 🔸 accordion bootstrap
    function format(d) {
        return `
            <div class="accordion" id="accordion-${d.id}">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button">
                            Dettagli contatto
                        </button>
                    </h2>
                    <div class="accordion-body">
                        <p><strong>Categoria:</strong> ${d.category_name}</p>
                        <p><strong>Azienda:</strong> ${d.company}</p>
                        <p><strong>Indirizzo:</strong> ${d.address ?? ''}</p>
                        <p><strong>Telefono:</strong> ${d.number}</p>
                        <p><strong>Email:</strong> ${d.email ?? ''}</p>
                        <p><strong>Note:</strong> ${d.notes ?? ''}</p>
                    </div>
                </div>
            </div>
        `;
    }

    // 🔸 toggle accordion FULL WIDTH
    $('#dataTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).find('button').text('+');
        } else {
            row.child(format(row.data()), 'child-row-full').show();
            tr.addClass('shown');
            $(this).find('button').text('-');
        }
    });

});