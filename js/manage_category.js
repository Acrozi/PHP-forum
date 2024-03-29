$(document).ready(function(){
	var categoryRecords = $('#categoryListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"bFilter": false,
		'serverMethod': 'post',
		"order":[],
		"ajax":{
			url:"action.php",
			type:"POST",
			data:{action:'categoryListing'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 1, 2],
				"orderable":false,
			},
		],
		"pageLength": 10
	});


	$('#addCategory').click(function(){
		$('#categoryModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$("#categoryModal").on("shown.bs.modal", function () {
			$('#categoryForm')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Skapa en till kategori");
			$('#action').val('addCategory');
			$('#save').val('Spara');
		});
	});

	$("#categoryListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getCategoryDetails';
		$.ajax({
			url:'action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){
				$("#categoryModal").on("shown.bs.modal", function () {
					$('#categoryForm')[0].reset();
					respData.data.forEach(function(item){
						$('#id').val(item['category_id']);
						$('#categoryName').val(item['name']);
						$('#description').val(item['description']);
					});
					$('.modal-title').html("<i class='fa fa-plus'></i> Ändra kategori");
					$('#action').val('updateCategory');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#categoryModal").on('submit','#categoryForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"action.php",
			method:"POST",
			data:formData,
			success:function(data){
				$('#categoryForm')[0].reset();
				$('#categoryModal').modal('hide');
				$('#save').attr('disabled', false);
				categoryRecords.ajax.reload();
			}
		})
	});

	$("#categoryListing").on('click', '.delete', function(){
		var id = $(this).attr("id");
		var action = "deleteCategory";
		if(confirm("Är du säker på att du vill ta bort den här inlägg?")) {
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {
					categoryRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
});
