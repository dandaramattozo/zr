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



/// CPF NOVOOOO

function isValidCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
        return false;
    }
    let sum = 0;
    let remainder;
    for (let i = 1; i <= 9; i++) {
        sum += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    remainder = (sum * 10) % 11;
    if (remainder === 10 || remainder === 11) {
        remainder = 0;
    }
    if (remainder !== parseInt(cpf.substring(9, 10))) {
        return false;
    }
    sum = 0;
    for (let i = 1; i <= 10; i++) {
        sum += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    remainder = (sum * 10) % 11;
    if (remainder === 10 || remainder === 11) {
        remainder = 0;
    }
    if (remainder !== parseInt(cpf.substring(10, 11))) {
        return false;
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    const cpfInput = document.getElementById('cpf');
    const form = document.querySelector('form');

    function handleFormSubmission(event) {
        const cpf = cpfInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        if (!isValidCPF(cpf)) {
            event.preventDefault(); // Previne o envio do formulário
            cpfInput.classList.add('is-invalid');
            const toastBody = document.getElementById('toast-body');
            toastBody.textContent = 'CPF inválido. Por favor, insira um CPF válido.';
            const toast = new bootstrap.Toast(document.getElementById('liveToast'));
            toast.show();
        } else {
            cpfInput.classList.remove('is-invalid');
        }
    }

    form.addEventListener('submit', handleFormSubmission);
});


// Verificação se o cpf é existe
$(document).ready(function() {
    $('#cpf').on('blur', function() {
        var cpf = $(this).val();

        // Validar o CPF
        if (CPF.isValid(cpf)) {
            // CPF é válido, agora verificar se já existe
            $.ajax({
                url: '/check-cpf',
                type: 'GET',
                data: { cpf: cpf },
                success: function(response) {
                    // Supondo que o endpoint retorna um JSON com um campo 'exists'
                    if (response.exists) {
                        $('#cpf').addClass('is-invalid');
                        $('#cpf').siblings('.invalid-feedback').text('Este CPF já está cadastrado.');
                    } else {
                        $('#cpf').removeClass('is-invalid').addClass('is-valid');
                        $('#cpf').siblings('.invalid-feedback').text('');
                    }
                },
                error: function() {
                    $('#cpf').addClass('is-invalid');
                    $('#cpf').siblings('.invalid-feedback').text('Erro ao verificar o CPF.');
                }
            });
        } else {
            $('#cpf').addClass('is-invalid');
            $('#cpf').siblings('.invalid-feedback').text('CPF inválido.');
        }
    });
});


// novo
function checkCpf(cpf) {
    $.ajax({
        url: '/controllers/checkCpfController.php', // Ajuste este caminho conforme necessário
        type: 'GET',
        data: { cpf: cpf },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.exists) {
                alert('O CPF já está cadastrado.');
            } else {
                alert('O CPF está disponível.');
            }
        },
        error: function() {
            alert('Erro ao verificar o CPF.');
        }
    });
}


$(document).ready(function() {
    $('#birth').on('blur', function() {
        const inputDate = new Date($(this).val());
        const today = new Date();

        if (inputDate > today) {
            $('#birth').addClass('is-invalid');
            $('#birth').siblings('.invalid-feedback').text('A data de nascimento não pode ser futura.');
        } else {
            $('#birth').removeClass('is-invalid').addClass('is-valid');
            $('#birth').siblings('.invalid-feedback').text('');
        }
    });
});


$(document).ready(function() {
    Inputmask({
        mask: ['(99) 9999-9999', '(99) 99999-9999'], 
        keepStatic: true,  // Força o uso da máscara correta conforme o número de dígitos
        showMaskOnHover: false,  
        showMaskOnFocus: false  
    }).mask('input[name="phone"]');
});