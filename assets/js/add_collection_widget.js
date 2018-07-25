$(document).ready(function () {
    $('.add-socialLink').click(function (e) {
        e.preventDefault();
        let linkList = $($(this).attr('data-list'));

        let linkCounter = linkList.data('widget-counter') | linkList.children().length;
        linkCounter += 1;
        if (!linkCounter) { linkCounter = linkList.children().length; }

        let newWidget = linkList.attr('data-prototype');

        newWidget = newWidget.replace(/__name__/g, linkCounter);
        linkCounter++;

        linkList.data('widget-counter', linkCounter);

        let newDiv = $('<div class="col-sm-10"></div>').html(newWidget);
        newDiv.appendTo(linkList);
    });

    $('.remove-socialLink').click(function(e) {
        e.preventDefault();
        let linkList = $($(this).attr('data-list'));

        let linkCounter = linkList.data('widget-counter') | linkList.children().length;
        if (!linkCounter) {
            linkCounter = linkList.children().length;
        }
        linkCounter--;
        linkList.data('widget-counter', linkCounter);
        let list = document.getElementById("socialLink-fields-list");
        if (list.lastElementChild && list.children.length >= 1) {
            list.removeChild(list.lastElementChild)
        }
    })
});