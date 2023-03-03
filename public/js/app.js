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

		if (!($(this).parent().hasClass('focused'))) {

			$(this).parent().parent().find('.sidebar-dropdown-menu').slideUp('fast')


			$(this).parent().parent().find('.has-dropdown').removeClass('focused')
		}

		$(this).next('.sidebar-dropdown-menu').slideToggle('fast')

		$(this).parent().toggleClass('focused')
	})

	$('.sidebar-toggle').click(function() {

		$('.sidebar').toggleClass('collapsed')

		$('.sidebar.collapsed').mouseleave(function() {
			// Hide dropdown menus
			$('.sidebar-dropdown-menu').slideUp('fast')

			// Remove focused class from menu items with dropdowns
			$('.sidebar-menu-item.has-dropdown, .sidebar-dropdown-menu-item.has-dropdown').removeClass('focused')
		})
	})

	$('.sidebar-toggle').click(function() {

		$(this).toggleClass('rotated');
	})

	// Show name when sidebar is hovered
	$('.sidebar').hover(function() {
		$('.sidebar-footer .dropdown .d-none').show();
		$('.sidebar-logo .text').hide();
	}, function() {
		$('.sidebar-footer .dropdown .d-none').hide();
		$('.sidebar-logo .text').show();
	});

	if (window.innerWidth < 768) {

		$('.sidebar').addClass('collapsed')
	}
	// Hide name when sidebar is not collapsed
	if (!$('.sidebar').hasClass('collapsed')) {
		$('.sidebar-logo .text').hide();
	}

	// Hide name when sidebar is not hovered
	$('.sidebar').mouseleave(function() {
		if (!$('.sidebar').hasClass('collapsed')) {
			$('.sidebar-logo .text').hide();
		}
	});

	// Hide name when sidebar is collapsed and not hovered
	$('.sidebar.collapsed').mouseleave(function() {
		$('.sidebar-logo .text').hide();
	});

	// Show name when sidebar is collapsed and hovered
	$('.sidebar.collapsed').hover(function() {
		$('.sidebar-logo .text').show();
	});

	// Hide name when sidebar is collapsed and not hovered
	$('.sidebar.collapsed').mouseleave(function() {
		$('.sidebar-logo .text').hide();
	});

	// Show name when sidebar is expanded and hovered
	$('.sidebar:not(.collapsed)').hover(function() {
		$('.sidebar-logo .text').show();
	});
	// end sidebar
})




