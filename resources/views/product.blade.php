<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ajax</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
</head>
<body>

     <div class="container my-4">
         <div class="row">
             <div class="col-md-4">
                <form>
                    @csrf
                    <div class="form-group mb-2">
                        <input type="text"  name="product" placeholder="Enter your product" class="form-control product_name">
                    </div>


                    <div class="form-group mb-2">
                        <input type="file" name="image"  class="form-control product_image">
                    </div>

                    <div class="form-group mb-2">
                       <button class="btn btn-success insert">save</button>
                    </div>

                </form>

                <div class="msg my-2"></div>
             </div>
             <div class="col-md-8">
                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th>id</th>
                             <th>product</th>
                             <th>
                               image
                             </th>
                         </tr>
                     </thead>

                         <tbody>

                         </tbody>
                 </table>
             </div>

             <form class="row justify-content-center align-items-center update" enctype="multipart/form-data">
                @csrf

                  <div class="col-md-8 " id="update">

                  </div>
             </form>

         </div>
     </div>


     <img src="" id="first" alt="">


     <script src="{{asset('css/jqueryfiledownload.js')}}"></script>


     <script>

     $(document).ready(function(){


         $("form").submit(function(e){

               e.preventDefault();

                let form=document.querySelector('form');

                 let formdata=new FormData(form);

                 $.ajax({

                     url:"{{route('product')}}",
                     type:"POST",
                     data:formdata,
                     contentType:false,
                     processData:false,
                     success:function(data){


                         if(data.message){


                            retrievingData();

                             console.log(data.message);

                           $(".msg").addClass("alert alert-success").html(data.message);

                           $("button").attr("disabled",true);

                          $("form").trigger("reset");


                          setTimeout(() => {

                              $(".msg").slideUp();
                          }, 2000);



                         }else{


                            $(".msg").addClass("alert alert-danger").html(data.message);


                            setTimeout(() => {

                            $(".msg").slideUp();
                            }, 2000);

                         }


                     }
                 });
         });


         retrievingData();

        //  this is for retrieving the data from the database


        function retrievingData(){

             $.ajax({

                 url:"{{route('getData')}}",
                 type:"GET",
                 dataType:'json',
                 success:function(data){

                    if(data.status==true){

                            $.each(data,function(index,value){

                                  for(let i=0;i<value.length;i++){

                                         $("tbody").append(`

                                         <tr>
                                             <td>${value[i].id}</td>
                                             <td>${value[i].id}</td>
                                             <td>${value[i].product_name}</td>
                                             <td>
                                                <img src="{{asset('images/${value[i].product_image}')}}" width='60px'>

                                                </td>

                                                 <td>
                                                    <button class='btn btn-danger btn-sm delete-btn' data-id='${value[i].id}'>delete</button>
                                                     <button class='btn btn-success btn-sm edit-btn' data-id='${value[i].id}'>Edit</button>
                                                        </td>
                                                </tr>
                                        `);

                                  }
                            });



                    }else{

                         alert("not done");
                    }

                 }
             });
        }


    $(document).on('click', '.delete-btn', function(e) {

    e.preventDefault(); // Prevent the default action

    // Get the item ID from the data-id attribute of the delete button
    var itemId = $(this).data('id');

    // Confirm deletion (optional)
    if (confirm('Are you sure you want to delete this item?')) {
        $.ajax({
            url: "/delete-item/" + itemId, // URL to your delete route (check Laravel route)
            type: 'POST',  // Use DELETE method
            data: {
                _token: "{{ csrf_token() }}", // Include CSRF token
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {

                        alert("Recored deleted successfully");


                } else {

                      console.log("not done");
                }
            },

        });
    }
});



    // this is the editing code here


    $(document).on("click", ".edit-btn", function() {
    let value = $(this).data('id');

    $.ajax({

        url: "/edit/" + value,
        type: "POST",
        dataType:"json",
        data: {
            _token: "{{ csrf_token() }}",  // Include CSRF token
        },
        success: function(data) {


             $.each(data,function(index,value){


                 $output= `


                    @csrf
                    <div class="form-group mb-2">
                        <input type="text"  name="product" value='${value.product_name}' class="form-control product_name">
                        <input type='text' class='id' value='${value.id}'></input>
                    </div>


                    <div class="form-group mb-2">
                        <input type="file" name="image"  class="form-control product_image">
                        <img src='{{asset('images/${value.product_image}')}}' width='60px'>
                    </div>

                    <div class="form-group mb-2">
                       <button class="btn btn-success update">update</button>
                    </div>

                  `;
             });

                   $("#update").html($output);

        },
    });
});


       $(document).on("submit",".update",function(e){

              e.preventDefault();

             let form=document.querySelector(".update");

             let id=$(".id").val();

             let formdata=new FormData(form);

              console.log(formdata);


               $.ajax({

                  url:"/update/"+id,
                  type:"POST",
                  processData:false,
                  contentType:false,
                  dataType:"json",
                  data: formdata,
                  success:function(data){

                        alert(data.message);
                  },
               });
       });

     });

     </script>

</body>
</html>
