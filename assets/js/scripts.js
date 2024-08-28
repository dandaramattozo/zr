$(document).ready(function() {
  
    $('#zipcode').inputmask('99999-999');
    $('#cpf').inputmask('999.999.999-99');

    $('#clientsTable').DataTable({
        "dom": "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "colReorder": true, 
        "language": {
            "search": "Buscar:", 
        }
    });

    $('#clientsTable_filter input').addClass('form-control form-control-sm');
    $('#clientsTable_filter label').addClass('form-label');

     // Adiciona o listener para exibir/ocultar colunas
     $('.column-toggle').on('change', function() {
        var column = $('#clientsTable').DataTable().column($(this).data('column'));
        column.visible(this.checked);
    });

    // Inicialmente oculta as colunas que não estão marcadas
    $('.column-toggle').each(function() {
        var column = $('#clientsTable').DataTable().column($(this).data('column'));
        column.visible(this.checked);
    });


    const fetchZipcodeData = (zipcode) => {
        $.ajax({
            url: `https://viacep.com.br/ws/${zipcode}/json/`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (!data.erro) {
                    $('#address').val(data.logradouro);
                    $('#neighborhood').val(data.bairro);
                    $('#city').val(data.localidade);
                    $('#state').val(data.uf);
                } else {
                    alert('CEP não encontrado.');
                }
            },
            error: function() {
                alert('Erro ao buscar o CEP.');
            }
        });
    };

    // Adiciona um listener para verificar o CEP quando o campo perde o foco
    $('#zipcode').on('blur', function() {
        const zipcode = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
        if (zipcode.length === 8) { // Verifica se o CEP tem 8 caracteres
            fetchZipcodeData(zipcode);
        }
    });


    // Adiciona um novo campo de contato
    $('#add-contact').on('click', function() {  
        const contactCount = $('#contacts-section .contact-row').length;

        // Adiciona um novo bloco de contato
        const newContactRow = `
            <div class="row contact-row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email-${contactCount + 1}" class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="client_contacts[${contactCount + 1}][email]" id="email-${contactCount + 1}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone-${contactCount + 1}" class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="client_contacts[${contactCount + 1}][phone]" id="phone-${contactCount + 1}" required>
                    </div>
                </div>
            </div>
        `;
        $('#contacts-section').append(newContactRow);
    });

   
});


// Máscara p/ o nome
document.getElementById('name').addEventListener('input', function() {
    var nome = this.value.trim();
        
    if (nome.indexOf(' ') === -1) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var toastLiveExample = document.getElementById('liveToast');
    if (toastLiveExample.querySelector('.toast-body').textContent.trim() !== '') {
        var toast = new bootstrap.Toast(toastLiveExample);
        toast.show();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Selecionar todos os checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        var isChecked = this.checked;
        var checkboxes = document.querySelectorAll('input[name="selected_clients[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });
});