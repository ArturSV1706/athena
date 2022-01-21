$(document).ready(function() {
    $('#listar-emprestimos').DataTable({
        dom: 'frtipB',
        buttons: [
            { "extend": 'pdf', exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]}, "text":'<span class="botao" style="border:0" ><i class="bx bxs-file-pdf bx-sm"></i> Baixar PDF</span>',"className": 'btn btn-default btn-xs'  },
            { "extend": 'excel',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]}, "text":'<span class="botao"><i class="bx bxs-spreadsheet bx-sm" ></i> Baixar Excel</span>',"className": 'btn btn-default btn-xs'  },
            { "extend": 'print',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]}, "text":'<span class="botao"><i class="bx bx-printer bx-sm" ></i> Imprimir</span>',"className": 'btn btn-default btn-xs'  },
        ],
        "order": [[ 0, "asc" ]],
        "scrollX": true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ empréstimos por pagina",
            "zeroRecords": "Sem registros, Crie um empréstimo de livro e ele aparecerá aqui :)",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Sem registros disponíveis",
            "infoFiltered": "(filtrando de _MAX_ registros totais)",
            "search": "Buscar: ",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Próximo",
                "previous": "Anterior"
            },
        },
    });
    var table = $('#listar-emprestimos').DataTable();
     
    $('#listar-emprestimos tbody').on('click', '#visualizar', function () {
        var meu_id = $(this).data('id');
        $.ajax({
            url: 'modal_visualizar.php',
            type: 'post',
            data: {
                meu_id: meu_id
            },
            success: function(response) {
                $('#modal-nosso-visualizar').html(response);
                document.getElementById('modal-visualizar').style.top = "0";
            }
        });
    } );

    $('#listar-emprestimos tbody').on('click', '#devolver', function () {
        var meu_id = $(this).data('id');
        var livro_id = $(this).data('livro_id');
        var utilizador_id = $(this).data('utilizador_id');
        $.ajax({
            url: 'modal_deletar.php',
            type: 'post',
            data: {
                meu_id: meu_id,
                livro_id: livro_id,
                utilizador_id: utilizador_id
            },
            success: function(response) {
                $('#modal-nosso-deletar').html(response);
                document.getElementById('modal-deletar').style.top = "0";
            }
        });
    } );

});