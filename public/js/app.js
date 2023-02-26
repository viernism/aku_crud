$(document).ready(function() {
    // sidebar
        // if (typeof $ === 'undefined') {
        //     console.log('jQuery is not loaded');
        // } else {
        //     alert('Hello, world!');
        // }
        // Hide dropdown menus by default
        $('.sidebar-dropdown-menu').slideUp('fast')

        // Handle clicks on menu items with dropdowns
        $('.sidebar-menu-item.has-dropdown > a, .sidebar-dropdown-menu-item.has-dropdown > a').click(function(e) {
            e.preventDefault()

            if(!($(this).parent().hasClass('focused'))) {
                $(this).parent().parent().find('.sidebar-dropdown-menu').slideUp('fast')
                $(this).parent().parent().find('.has-dropdown').removeClass('focused')
            }

            $(this).next('.sidebar-dropdown-menu').slideToggle('fast')
            $(this).parent().toggleClass('focused')
        })

        $('.sidebar-toggle').click(function() {
            $('.sidebar').toggleClass('collapsed')

            $('.sidebar.collapsed').mouseleave(function() {
                $('.sidebar-dropdown-menu').slideUp('fast')
                $('.sidebar-menu-item.has-dropdown, .sidebar-dropdown-menu-item.has-dropdown').removeClass('focused')
            })
        })

        $('.sidebar-toggle').click(function() {
            $(this).toggleClass('rotated');
        })

        if(window.innerWidth < 768) {
            $('.sidebar').addClass('collapsed')
        }
    // end sidebar
})
