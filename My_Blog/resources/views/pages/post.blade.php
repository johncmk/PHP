@extends('master')

@section('content')

	<script type="text/javascript">
		$(document).ready(function(){
			init_progress();
			tinyMCE.init({ 
                    mode: 'exact', 
                    selector: '#w_comment',
                    content_css : "{{ asset('css/tinymce_content.css') }}",
                    extended_valid_elements  : "iframe[src|width|height|name|align]", //this doesn't work
                    width : "890px",
                    height: "510px", 
                });
             // tinymce.activeEditor.setContent(''); // This is empty the textarea field

             $('#write').hide();
             $('#edit').hide();
             $('#show_detail').hide();
		});

		function search() {
			$('#frm_search').submit();
		}		

		function removeTinyMCE(inst) {
            tinyMCE.execCommand('mceRemoveControl', false, inst);
        }

		function show_detail( p_id ) {

			do_action("show_detail");

			show_progress();
			$.ajax({
				url:"{{ route('action_show_detail') }}",
				headers: {
                 	'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
				data: {
					p_id:p_id
				},
				cache:false,
				type:"POST",
				dataType:"json",
				success: function(res){
					hide_progress();
					if( $.trim(res.msg) === "") {
						var title = res.rs['title'];
						var comment = res.rs['comment'];
						var p_id = res.rs["p_id"];

						$('#r_title').text(title);
						$('#r_comment').html(comment);
						$('#r_p_id').val(p_id);

					}else {
						hide_progress();
						alert(res.msg);
					}
				}
			});	
		}

		function edit() {
	
			var e_p_id = $('#w_p_id').val();
			var e_title = $('#w_title').val();
			var content = tinyMCE.activeEditor.getContent({format : 'html'});	
			var e_comment = content;

			show_progress();
			$.ajax({
				url:"{{ route('action_edit') }}",
				headers: {
                 	'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
				data: {
					p_id: e_p_id,
					title: e_title,
					comment: e_comment
				},
				cache:false,
				type:"POST",
				dataType:"json",
				success: function(res){
					hide_progress();
					if( $.trim(res.msg) === "") {
						alert("Edit Complete");

						$('#r_title').text(e_title);
						$('#r_comment').html(e_comment);
						$('#r_p_id').val(e_p_id);

						search();	
						// show_detail(e_p_id);
					}else {
						hide_progress();
						alert(res.msg);
					}
				}
			});	
		}

		function remove_post() {

			var res = confirm("Are you sure?")

			if(!res) return;

			var r_p_id = $('#r_p_id').val();

			show_progress();
			$.ajax({
				url: "{{ route('action_remove') }}",
				headers: {
                 	'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
				data: {
					p_id:r_p_id
				},
				cache:false,
				type:"POST",
				dataType:"json",
				success: function(res){
					hide_progress();
					if( $.trim(res.msg) === "") {
						alert("Delete Complete");
						$('#show_detail').hide();
						search();	
					}else {
						hide_progress();
						alert(res.msg);
					}
				}
			});	
		}

		function action_write() {
            
            var title = $('#w_title').val();
            var content = tinyMCE.activeEditor.getContent({format : 'html'});           
            var comment = content;
            // var user_id = $('#w_user_id').val();
            
            show_progress();
            $.ajax({
                url:"{{ route('action_write') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {
                    title:title,
                    comment:comment
                    // ,user_id:user_id
                },
                cache:false,
                type:"POST",
                dataType:"json",
                success: function(res){
                    hide_progress();
                    if( $.trim(res.msg) === "") {
                    	var last_id = res.rs['last_id'];
                        alert("Submit Complete "+ last_id);
                        search();
                        // show_detail(last_id);
                    }else {
                    	hide_progress();
                        alert(res.msg);
                    }
                }
            }); 
        }

		function do_action(act_type){

			var w_div = $('#write');
			var e_div = $('#edit');
			var s_div = $('#show_detail');

			var w_btn = $('#btn_submit');
			var e_btn = $('#btn_edit');

			show_progress();
			switch( act_type ) {
				case "write":
					s_div.hide();
					e_btn.hide();

					$('#w_title').val("");
					tinymce.activeEditor.setContent('');

					$('#w_title').focus();
					w_div.show();
					w_btn.show();
					break;
				case "edit":
					var title = $('#r_title').html();
					var comment = $('#r_comment').html();

					$('#w_p_id').val($('#r_p_id').val());
					$('#w_title').val(title);
					tinymce.activeEditor.setContent(comment);

					s_div.hide();
					w_btn.hide();

					w_div.show();
					e_btn.show();
					$('#w_title').focus();
					break;
				case "show_detail":
					w_div.hide();
					$('#delete_btn').show();
					$('#edit_btn').show();
					s_div.show();
					s_div.focus();
					break;
				case "c_write":
					w_div.hide();
					s_div.hide();
					break;
				default:
					w_div.hide();
					s_div.hide();
					w_btn.hide();
					e_btn.hide();
					break;
			}
			hide_progress();

		}

	</script>

	<!-- Use CKEditor to replace textarea -->

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-color:green; border: 1px solid black">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>Post Me</h1>
                        <hr class="small">
                        <span class="subheading">This is what I do.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Write/Edit Content -->
    <div id="write" name="write" class="container" >
    	<input id="w_p_id" name="w_p_id" style="display:none" value="">
        <div class="row">
            <div class="col-sm-7" style="margin-bottom:10px">
                <div><b style="margin-right:10px;font-size:20px">Title :</b>
                <input id="w_title" name="w_title" type="text" style="width:600px"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <textarea id="w_comment" name="w_comment"></textarea>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <input id="btn_submit" name="btn_submit" class="btn btn-primary pull-right" type="submit" style="margin-left:10px;display:none" value="Submit" onclick="action_write()">
        	<input id="btn_edit" name="btn_edit" class="btn btn-primary pull-right" type="button" style="margin-left:10px;display:none" value="Edit" onclick="edit()">
        	<input id="btn_cancel" name="btn_cancel" class="btn btn-primary pull-right" type="button" style="margin-right:10px" value="Cancel" onclick="do_action('c_write')">
        </div>
    </div>
    <!-- End -->

	<!-- Show Detail  -->
    <div id="show_detail" class="container" style="display:none;margin-bottom:10px; padding: 20px">
    	<!-- ID -->
		<input id="r_p_id" name="r_p_id" style="display:none" value="">

    	<!-- Title -->
    	<div class="row">
			<h1>
				<b>
					<div id="r_title"></div>
				</b>
			</h1>
		</div>
		<!-- Separated Line -->
		<div class="row">
			<hr style="width: 100%; color: black; height: 1px; background-color:black;" />
			
			<!-- Comment; Body of the content -->
			<div id="r_comment"></div>

			<hr style="width: 100%; color: black; height: 1px; background-color:black;" />
		</div>
		
		<!-- Edit and Delete button -->
		<div class="row">
			<div class="col-sm-4">
				<!-- Empty -->
			</div>
			<div class="col-sm-4">
				<!-- Emtpy -->
			</div>
			<div class="col-sm-4 ">
				@if(auth()->guest())
                	<!-- Empty -->
                @else
                	<input type="submit" value="Delete" id="delete_btn" name="delete_btn" class="btn btn-primary pull-right" onclick="remove_post()" style="margin-left:5px">
					<input type="submit" value="Edit" id="edit_btn" name="edit_btn" class="btn btn-primary pull-right" onclick="do_action('edit')" style="margin-right:5px">
                @endif
			</div>
    	</div>
    </div>
    <!-- End  -->

     <!-- Post Content -->
    <div class="container" style="margin-top:10px; padding:20px">
    	<div class="row">
			<table id="table_new" class="table table-striped table-condensed hover table-bordered" cellspacing="0" width="100%">
			    <thead>
			        <tr>
			        	<td><b>No</b></td>
			            <th>Title</th>
			            <th>Post.ID</th>
			            <th>User</th>
			            <th>Date</th>
			        </tr>
			    </thead>
			    <tbody>
			    @for($i = 0; $i < count($RS); $i++)
			    	<tr>
			    		<td>
			    			{{ $i+1 }}
			    		</td>
			    		<td>
 							<a style='color:blue;' href='javascript:show_detail("{{ $RS[$i]->p_id }}")'>{{ $RS[$i]->title }}</a>
			    		</td>
			    		<td>
			    			{{ $RS[$i]->p_id }}
			    		</td>
			    		<td>
			    			{{ $RS[$i]->username }}
			    		</td>
			    		<td>
			    			{{ $RS[$i]->edate }}
			    		</td>
			    	</tr>
			    @endfor
			    </tbody>
			</table>
			</div>

			<!-- Pagination -->
			<div class="row text-center">
					<ul class="pagination" style="padding:0%">
						<?php if($current_page > 0) {
					   			echo "<li><a href='/post?current_page=1&title_val=$title'>First</a></li>"; 
						   		$prev = $current_page - 1;
						   		if($prev <= 0)
						   			echo "<li><a href='/post?current_page=1&title_val=$title'>Previous</a></li>";
						   		else
						   			echo "<li><a href='/post?current_page=$prev&title_val=$title'>Previous</a></li>";
						   	}

						   	for ($x = ($current_page - $range); $x < (($current_page + $range) + 1); $x++) {
								   if (($x > 0) && ($x <= $total_pages)) {
								      if ($x == $current_page) {
								         echo " <li class='active'><a>$x</a></li> ";
								      } else {
								         echo " <li><a href='/post?current_page=$x&title_val=$title'>$x</a></li>";
								      } // end else
								   } // end if 
								} // end for

							// if ($current_page != $total_pages) {
							   $next = $current_page + 1;
							   echo " <li><a href='/post?current_page=$next&title_val=$title'>Next</a></li>";
							   echo " <li><a href='/post?current_page=$total_pages&title_val=$title'>Last</a></li>";
							// } // end if
						?>
					</ul>
			</div>
			<!-- pagination -->
    </div>
    <!-- End -->


    <!-- Submenu Bar -->
    <div class="container" style="margin-bottom:10px; padding: 20px">
	    	<div class="row">
	    		<!-- <div class="col-sm-4"> -->
	    			<!-- Empty -->
	    		<!-- </div> -->
	    		<div class="col-md-2 col-md-offset-5">
	    		<!-- <div class="col-sm-4"> -->
	    			<form id="frm_search" name="frm_search" method="get" action="{{ route('action_search') }}">
	    				<div class="input-group">
		    				<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input id="title" name="title" class="form-control" type="text" placeholder="Search" value="">
	               	 		<div class="input-group-btn">
		               	 		<button class="btn btn-default" type="submit" onclick="search()">
		               	 			<i class="glyphicon glyphicon-search"></i>
		               	 		</button>
	               	 		</div>
           				</div>
					</form>
				</div>
	    		<div class="col-md-5 pull-right">
	    			@if(auth()->guest())
	                	<!-- Empty -->
	                @else
			    		<input type="button" value="Write" id="write" name="write" class="btn btn-primary pull-right" type="button" onclick="do_action('write')">
			    		<!-- <a class="btn btn-primary" href="{{ route('to_write') }}">Write</a> -->
	                @endif
	    		</div>
			</div>
    </div>
    <!-- End -->
@stop