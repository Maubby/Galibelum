$(document).ready(function() {
    $("#table_manager").DataTable({
        "language": {
            "emptyTable": "Aucun résultat pour votre recherche",
            "info": "_START_ à _END_ sur _TOTAL_ résultats",
            "infoEmpty": "0 à 0 sur 0 résultat",
            "lengthMenu": "_MENU_ résultats par page",
            "loadingRecords": "Chargement...",
            "processing": "En cours...",
            search: "_INPUT_",
            searchPlaceholder: "Recherche...",
            "zeroRecords": "Aucun résultat pour votre recherche",
            "paginate": {
                "next": "Suivant",
                "previous": "Précédent"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    })
});

$(document).ready(function() {
    $("#table-manager").DataTable({
        'searching': false,
        "language": {
            "emptyTable": "Aucun résultat pour votre recherche",
            "info": "_START_ à _END_ sur _TOTAL_ résultats",
            "infoEmpty": "0 à 0 sur 0 résultat",
            "lengthMenu": "_MENU_ résultats par page",
            "loadingRecords": "Chargement...",
            "processing": "En cours...",
            "zeroRecords": "Aucun résultat pour votre recherche",
            "paginate": {
                "next": "Suivant",
                "previous": "Précédent"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    })
});
