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

$(document).ready(function() {
    $('#editGedungModal, #deleteGedungModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var gedungId = button.data('gedung-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':gedungId', gedungId);
        form.attr('action', action);
        form.find('#gedungId').val(gedungId);
      });

      $('#editSekolahModal, #deleteSekolahModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var sekolahId = button.data('sekolah-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':sekolahId', sekolahId);
        form.attr('action', action);
        form.find('#sekolahId').val(sekolahId);
      });

      $('#editHealthModal, #deleteHealthModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var healthId = button.data('health-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':healthId', healthId);
        form.attr('action', action);
        form.find('#healthId').val(healthId);
      });

      $('#editKulinerModal, #deleteKulinerModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var kulinerId = button.data('kuliner-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':kulinerId', kulinerId);
        form.attr('action', action);
        form.find('#kulinerId').val(kulinerId);
      });

      $('#editTokoModal, #deleteTokoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var tokoId = button.data('toko-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':tokoId', tokoId);
        form.attr('action', action);
        form.find('#tokoId').val(tokoId);
      });

      $('#editOfficeModal, #deleteOfficeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var officeId = button.data('office-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':officeId', officeId);
        form.attr('action', action);
        form.find('#officeId').val(officeId);
      });

      $('#editOfficeModal, #deleteOfficeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var officeId = button.data('office-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':officeId', officeId);
        form.attr('action', action);
        form.find('#officeId').val(officeId);
      });

      $('#editBuscenModal, #deleteBuscenModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var buscenId = button.data('buscen-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':buscenId', buscenId);
        form.attr('action', action);
        form.find('#buscenId').val(buscenId);
      });

      $('#editBuscenModal, #deleteBuscenModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var buscenId = button.data('buscen-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':buscenId', buscenId);
        form.attr('action', action);
        form.find('#buscenId').val(buscenId);
      });

      $('#editTourismModal, #deleteTourismModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var tourismId = button.data('tourism-id');
        var form = $(this).find('form');
        var action = form.attr('action').replace(':tourismId', tourismId);
        form.attr('action', action);
        form.find('#tourismId').val(tourismId);
      });

      // ewww old code thats too shitty so i had to recode, well shitty as in not effective lol when you can do that in 8 lines instead
    // // Updates the form action URL with the gedung ID when submitted
    // $('a.edit').click(function(event) {
    //     var gedungId = $(this).data('gedung-id');
    //     var form = $('#editGedungModal').find('form');
    //     var actionUrl = form.attr('action').replace(':gedungId', gedungId);
    //     form.attr('action', actionUrl);
    // });

    // // Update the action attribute of the edit gedung form when the modal is shown
    // $('#editGedungModal').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget);
    //     var gedungId = button.data('gedung-id');
    //     var form = $(this).find('form');
    //     var action = form.attr('action').replace(':gedungId', gedungId);
    //     form.attr('action', action);
    // });

    // // Update the action attribute of the delete gedung form when the modal is shown
    // $('#deleteGedungModal').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget);
    //     var gedungId = button.data('gedung-id');
    //     var form = $(this).find('form');
    //     var action = form.attr('action').replace(':gedungId', gedungId);
    //     form.attr('action', action);
    // });
});


// bro i dont know how i actually did all of this, I DONT REMEMBER dODUING IT
//hell yeah some copied js  for cropping modal

var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;
$("body").on("change", ".image", function(e) {
    var files = e.target.files;
    var done = function(url) {
        image.src = url;
        $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});
$modal.on('shown.bs.modal', function() {
    cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: '.preview'
    });
}).on('hidden.bs.modal', function() {
    cropper.destroy();
    cropper = null;
});
$("#crop").click(function() {
    canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
    });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            var base64data = reader.result;
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "crop-image-upload",
                data: {
                    '_token': $('meta[name="_token"]').attr('content'),
                    'image': base64data
                },
                success: function(data) {
                    console.log(data);
                    $modal.modal('hide');
                    alert("Crop image successfully uploaded");
                }
            });
        }
    });
})
