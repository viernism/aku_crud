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

    // Add 'active' class to clicked sidebar-menu-item
  $('.sidebar-menu-item').click(function() {
    // Check if the clicked sidebar-menu-item has the 'has-dropdown' class
    if ($(this).hasClass('has-dropdown')) {
      return; // Do nothing if the clicked sidebar-menu-item has the 'has-dropdown' class
    }
    // Remove 'active' class from all sidebar-menu-items
    $('.sidebar-menu-item').removeClass('active');
    // Add 'active' class to the clicked sidebar-menu-item
    $(this).addClass('active');
  });

    // // Add active class to chosen sidebar-menu-item
    // $('.sidebar-menu-item a').click(function() {
    //     // Remove active class from all items
    //     $('.sidebar-menu-item').removeClass('active');
    //     // Add active class to the chosen item
    //     $(this).parent().addClass('active');
    // });

    // // Exclude items with class "has-dropdown"
    // $('.sidebar-menu-item.has-dropdown a').click(function() {
    //     $(this).parent().removeClass('active');
    // });

    // Add 'active' class to corresponding sidebar-menu-item
  $(".sidebar-menu-item").each(function(){
        if ($(this).attr("href") == window.location.pathname){
            $(this).addClass("active");
        }
    });
    // ah this code doesnt work ;(

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

    // Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();

	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;
			});
		} else{
			checkbox.each(function(){
				this.checked = false;
			});
		}
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});

	// end sidebar

})

$(document).ready(function() {
    // Updates the form action URL with the usesr ID when submitted
    $('a.edit').click(function(event) {
        var userId = $(this).data('user-id');
        var form = $('#editUserForm');
        var actionUrl = form.attr('action').replace('1', userId);
        form.attr('action', actionUrl);
    });

     // Update the action attribute of the edit user form when the modal is shown
     $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('user-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':userId', userId);
        form.attr('action', action);
    });

    // Update the action attribute of the delete user form when the modal is shown
    $('#deleteUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('user-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':userId', userId);
        form.attr('action', action);
    });
});
