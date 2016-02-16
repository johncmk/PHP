@extends('master')
 
@section('content')

    <script type="text/javascript">

        $(document).ready(function(){
               tinyMCE.init({ 
                    mode: 'exact', 
                    selector: '#w_comment',
                    content_css : "{{ asset('css/tinymce_content.css') }}",
                    extended_valid_elements  : "iframe[src|width|height|name|align]", //this doesn't work
                    width : "890px",
                    height: "510px", 
                });
             // tinymce.activeEditor.setContent(''); // This is empty the textarea field
        });

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
                        alert("Submit Complete "+ res.rs['last_id']);
                        window.location.replace("{{ route('sample_post') }}");
                    }else {
                        alert(res.msg);
                    }
                }
            }); 
        }

     

    </script>

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

    <!-- Main Content -->
    <!-- Write Pop -->
    <div id="write" name="write" class="container" >
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
    </div>

    <div class="container">
        <div class="row" style="margin-top:10px">
            <input class="btn btn-primary pull-right" type="submit" value="submit" onclick="action_write()">
        </div>
    </div>
    <!-- End -->
@stop