$(document).ready(function () {
    $('.add-socialLink').click(function (e) {
        e.preventDefault();

        let linkList = $('#socialLink-fields-list');

        let linkCounter = linkList.data('widget-counter') | linkList.children().length;
        if (!linkCounter) { linkCounter = linkList.length; }

        let newWidget = linkList.attr('data-prototype');

        newWidget = newWidget.replace(/__name__/g, linkCounter);
        linkCounter++;

        let newDiv = $('<div class="col-sm-11"></div>').html(newWidget);
        newDiv.appendTo(linkList);
    });
});
