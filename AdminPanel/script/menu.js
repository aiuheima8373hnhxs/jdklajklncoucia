$(document).ready(function() {
    var nav = $('nav.mt-2');
    var activeItem = nav.find('a.active');
    activeItem.parents('li.has-treeview').addClass('menu-open');
});