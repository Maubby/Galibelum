// add-collection-widget.js
jQuery(document).ready(function () {
    jQuery('.add-another-collection-widget').click(function (e) {
        var list_1 = jQuery(jQuery(this).attr('data-list-1'));
        // Try to find the counter_1 of the list_1
        var counter_1 = list_1.data('widget-counter_1') | list_1.children().length;
        // If the counter_1 does not exist, use the length of the list_1
        if (!counter_1) { counter_1 = list_1.children().length; }

        // grab the prototype template
        var newWidget = list_1.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter_1);
        // Increase the counter_1
        counter_1++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list_1.data(' widget-counter_1', counter_1);

        // create a new list_1 element and add it to the list_1
        var newElem_1 = jQuery(list_1.attr('data-widget-tags')).html(newWidget);
        newElem_1.appendTo(list_1);


        var list_2 = jQuery(jQuery(this).attr('data-list-2'));
        // Try to find the counter_2 of the list_2
        var counter_2 = list_2.data('widget-counter_2') | list_2.children().length;
        // If the counter_2 does not exist, use the length of the list_2
        if (!counter_2) { counter_2 = list_2.children().length; }

        // grab the prototype template
        var newWidget_2 = list_2.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget_2 = newWidget_2.replace(/__name__/g, counter_2);
        // Increase the counter_2
        counter_2++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list_2.data(' widget-counter_2', counter_2);

        // create a new list_2 element and add it to the list_2
        var newElem_2 = jQuery(list_2.attr('data-widget-tags')).html(newWidget_2);
        newElem_2.appendTo(list_2);
    });
});