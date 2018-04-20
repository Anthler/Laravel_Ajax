<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ajax Tutorial</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
</head>
<body>

<div class="container">
	<div class="row mb-5">
		
		<div class="col-lg-6 offset-2">
			
			
			
			<div class="card" id="card-body">
				<div class="card-header">
					<h3>My To do List</h3>
						<a href="#" class="pull-right" data-toggle="modal" data-target="#exampleModal" id="addButton"> 
							<i class="fa fa-plus"></i>
						</a>
				</div>
				<div class="card-body">
					@foreach($items as $item)
					<ul class="list-group">
						
					  <li class="list-group-item ourItem" data-toggle="modal" data-target="#exampleModal">{{$item->item}}
						<input type="hidden" id="itemId" value="{{$item->id}}">
					  </li>
					 
				</ul>
					@endforeach
				</div>
			</div>
			</div>

			
			<div class="col-lg-2">
				<input type="text" class="form-control" name="searchItem" id="searchItem" placeholder="Search">
			</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Add New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="id">
        <input type="text" class="form-control" id="addItem">
      </div>
      <div class="modal-footer">
        <button type="button" style="display:none;" class="btn btn-danger" id="delete" data-dismiss="modal">delete</button>
        <button type="button" class="btn btn-info" style="display:none;" id="save_changes" data-dismiss="modal">Save Changes</button>
        <button type="button" class="btn btn-success" id="addNew" data-dismiss="modal">Add new</button>
      </div>
    </div>
  </div>
</div>
		
	</div>
</div>


{{csrf_field()}}



<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>	
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script>
	$(function(){

		var buttons = $('.ourItem');
		//var addButton = $('.addButton');

		$(document).on('click','.ourItem',function(e){
				var text = $.trim($(this).text());
				var id = $(this).find('#itemId').val();
				$('#title').text('Edit Item');
				$('#delete').show();
				$('#save_changes').show();
				$('#addItem').val(text);
				$('#addNew').hide();
				$('#id').val(id);
				console.log(text);
		});


		$(document).on('click','#addButton',function(e){

				$('#title').text('Add New New');
				$('#delete').hide();
				$('#save_changes').hide();
				$('#addItem').val("");
				$('#addNew').show().text("Add New Item");
			});

		$('#addNew').click(function(e){
				var text = $('#addItem').val();
				$.post("/",{'text':text, '_token':$('input[name=_token]').val()},function(data){

					console.log(data);

					$('#card-body').load(location.href + ' #card-body' );
				});


		});

		$('#delete').click(function(event){
			var id = $('#id').val();
			$.post('delete',{'id':id, '_token':$('input[name=_token]').val()},function(data){

				$('#card-body').load(location.href + ' #card-body' );
				//console.log(data);
			});
		});

		$('#save_changes').click(function(event){
			var id = $('#id').val();
			var item = $.trim($('#addItem').val());
			$.post('update',{'id':id, 'item':item, '_token':$('input[name=_token]').val()},function(data){
				$('#card-body').load(location.href + ' #card-body' );
				//console.log(data);
			});
		});

	
    $( "#searchItem" ).autocomplete({
      source: 'http://127.0.0.1:8000/search'
    });
		});



	</script>
</body>
</html>