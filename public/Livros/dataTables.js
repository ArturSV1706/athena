$(document).ready(function() {
    $('#listar-livros').DataTable({
        dom: 'frtipB',
        buttons: [
            { "extend": 'pdf', exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]}, "text":'<span class="botao" style="border:0" ><i class="bx bxs-file-pdf bx-sm"></i> Baixar PDF</span>',"className": 'btn btn-default btn-xs'  },
            { "extend": 'excel',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]}, "text":'<span class="botao"><i class="bx bxs-spreadsheet bx-sm" ></i> Baixar Excel</span>',"className": 'btn btn-default btn-xs'  },
            { "extend": 'print',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]}, "text":'<span class="botao"><i class="bx bx-printer bx-sm" ></i> Imprimir</span>',"className": 'btn btn-default btn-xs'  },
        ],
        "order": [[ 0, "asc" ]],
        "scrollX": true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ livros por pagina",
            "zeroRecords": "Sem registros, adicione um livro e ele aparecerá aqui :)",
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
        }



    });

    var table = $('#listar-livros').DataTable();
     
    $('#listar-livros tbody').on('click', '#visualizar', function () {
        var meu_id = $(this).data('id'); //pega o id que o botão passou
        $.ajax({
            url: 'modal_visualizar.php', //indica o arquivo que vai adicionar conteúdo ao modal
            type: 'post',
            data: {
                meu_id: meu_id //passa o id do registro clicado para o arquivo chamado acima
            },
            success: function(response) {
                $('#modal-nosso-visualizar').html(response);
                document.getElementById('modal-visualizar').style.top = "0";
            }
        });
    } );

    $('#listar-livros tbody').on('click', '#editar', function () {
        var meu_id = $(this).data('id'); //pega o id que o botão passou
        $.ajax({
            url: 'modal_editar.php', //indica o arquivo que vai adicionar conteúdo ao modal
            type: 'post',
            data: {
                meu_id: meu_id //passa o id do registro clicado para o arquivo chamado acima
            },
            success: function(response) {
                $('#modal-nosso-editar').html(response);
                document.getElementById('modal-editar').style.top = "0";
            }
        });
    } );

    $('#listar-livros tbody').on('click', '#deletar', function () {
        var meu_id = $(this).data('id'); //pega o id que o botão passou
        $.ajax({
            url: 'modal_deletar.php', //indica o arquivo que vai adicionar conteúdo ao modal
            type: 'post',
            data: {
                meu_id: meu_id //passa o id do registro clicado para o arquivo chamado acima
            },
            success: function(response) {
                $('#modal-nosso-deletar').html(response);
                document.getElementById('modal-deletar').style.top = "0";
            }
        });
    } );

});