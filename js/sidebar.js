$.fn.Sidebar = function (options) {
    let settings = $.extend({
        openTriggerId: 'sidebar-open',
        closeTriggerId: 'sidebar-close',
        header: 'Header',
        headerRef: '#',
        items: {
            'Item1': '#',
            'Item2': '#',
            'Item3': '#'
        },
        width: 120,
        sidebarColor: 'gray', // color
        closeButtonColor: 'black',
        headerColor: 'white',
        textColor: 'white',
        textAlign: 'left',
        sidebarClass: 'sidebar-menu', // class
        headerClass: 'sidebar-header',
        itemsClass: 'sidebar-item',
        closeButtonClass: 'sidebar-close',
        closeButtonIcon: '&times;' // close icon
    }, options);

    // Init Sidebar
    let sidebar = this.addClass(settings.sidebarClass).css({
        'margin-left': 0,
        'height': '100%',
        'width': 0,
        'position': 'fixed',
        'z-index': 1,
        'top': 0,
        'left': 0,
        'background-color': settings.sidebarColor,
        'overflow-x': 'hidden',
        'padding-top': '60px',
        'transition': '0.5s',
        'text-align': settings.textAlign
    });

    // Append Menu Close Button
    sidebar.append($('<a href="#" id="' + settings.closeTriggerId + '">').append(settings.closeButtonIcon).css({
        'text-decoration': 'none',
        'color': settings.closeButtonColor,
        'display': 'block',
        'position': 'absolute',
        'top': 0,
        'right': '25px',
        'font-size': '36px',
        'margin-left': '50px'
    }));

    // Append Menu Header
    sidebar.append($('<a href="'+settings.headerRef+'" class="' + settings.headerClass + '">').append(settings.header).css({
        'text-decoration': 'none',
        'color': settings.headerColor,
        'font-size': '2rem',
        'display': 'block'
    }));

    for (const property in settings.items) {
        sidebar.append($('<a href="'+settings.items[property]+'" class="' + settings.itemsClass + '">').append(property).css({
            'text-decoration': 'none',
            'color': settings.textColor,
            'display': 'block',
            'transition': '0.3s',
            'margin-top': '0.5rem'
        }));
    }

    // Show/Open Sidebar
    $('#' + settings.openTriggerId).click(function () {
        sidebar.css({
            'width': settings.width + 'px',
            'padding-left': '5px'
        });
    });
    $('#' + settings.closeTriggerId).click(function () {
        sidebar.css({
            'width': '0',
            'padding-left': '0'
        });
    });
}
