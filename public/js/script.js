$('#commentForm').on('submit',function(e){
    e.preventDefault();

    var postData=new FormData($("#commentForm")[0]);
           
    $.ajax({
        url: "/comments",
        type:"POST",
        data: postData,
        processData: false,
        contentType: false,
        success:function(response){
            toastr.success(response.message);
            $("#comment-card").load(location.href + " #comment-card>*", "");
        },
        error: function(response) { 
            var errors = $.parseJSON(response.responseText); 
            $.each(errors.errors, function (key, val) { 
                toastr.error(val[0]); 
            });
            if(response.errorMessage!=undefined){
                toastr.error(response.error);
            }
        }
      });
});

function editComment(id){
    $("#updateCommentDiv-"+id).attr("style", "display:block !important");
}

function updateComment(id){
    var postData=new FormData($("#commentUpdateForm-"+id)[0]);
           
    $.ajax({
        url: "/comments",
        type:"POST",
        data: postData,
        processData: false,
        contentType: false,
        success:function(response){
            toastr.success(response.message);
            $("#comment-card").load(location.href + " #comment-card>*", "");
        },
        error: function(response) { 
            var errors = $.parseJSON(response.responseText); 
            $.each(errors.errors, function (key, val) { 
                toastr.error(val[0]); 
            });
            if(response.errorMessage!=undefined){
                toastr.error(response.error);
            }
        }
      });
};

function deleteComment(id){
    $.ajax({
        url: "/comments/"+id,
        type:"DELETE",
        data: {
            "_token": "{{ csrf_token() }}"
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        processData: false,
        contentType: false,
        success:function(response){
            toastr.success(response.message);
            $("#comment-card").load(location.href + " #comment-card>*", "");
        },
        error: function(response) { 
            if(response.errorMessage!=undefined){
                toastr.error(response.error);
            }
        }
    });
}

//Search Using Ajax-Not Completed
$("#select-cat").change(function(event){
    var selected_val=$(this).val();
    
    $.ajax({
        url: "/blogs/search/"+$("#select-cat option:selected").text(),
        type:"GET",
        data: {
           "selected_cat" : selected_val
        },
        success:function(response){
            $('#blog-section').empty();
            var html='<div class="row row-cols-1 row-cols-md-3">';
            response.blogs.forEach(element => {
                html+='<div class="col mb-4"><div class="card h-100"><img src="images/'+element.image+'" class="card-img-top w-100" alt="Blog Image"><div class="card-body"><h5 class="card-title">'+element.title+'</h5><p class="card-text">'+element.content.substr(0,100)+'</p><div><p class="text-small">Posted by:';
            });

            $('#blog-section').prepend(html);
        },
        error: function(response) { 
            
        }
    });
});

