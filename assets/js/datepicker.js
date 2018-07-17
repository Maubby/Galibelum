$.fn.datepicker.dates['fr'] = {
    days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
    daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
    daysMin: ["D", "L", "Ma", "Me", "J", "V", "S", "D"],
    months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
    monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Déc"],
    today: "Aujourd'hui",
    clear: "Effacer",
    weekStart: 1,
    format: "dd-mm-yyyy"
};
$(document).ready(function() {
    /* Set language to FR with dates["fr'] options */
    $.fn.datepicker.defaults.language = 'fr';

    /* Start datepicker at page loading */
    $('.js-datepicker').datepicker({
        startDate: new Date()
    });
});