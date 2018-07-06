$(document).ready(function() {
    $("#table-manager").DataTable({
        "language": {
            "emptyTable": "Aucun résultat pour votre recherche",
            "info": "_START_ à _END_ sur _TOTAL_ résultats",
            "infoEmpty": "0 à 0 sur 0 résultat",
            "lengthMenu": "_MENU_ résultats par page",
            "loadingRecords": "Chargement...",
            "processing": "En cours...",
            "search": "Recherche:",
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

