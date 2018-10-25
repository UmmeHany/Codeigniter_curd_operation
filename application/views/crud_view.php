<html>  
 <head> 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
      <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>   
   <title><?php echo $title; ?></title>  
       
   <style>  
           body  
           {  
                margin:0;  
                padding:0;  
                background-color:#f1f1f1;  
           }  
           .box  
           {  
                width:900px;  
                padding:20px;  
                background-color:#fff;  
                border:1px solid #ccc;  
                border-radius:5px;  
                margin-top:10px;  
           }  
      </style>  
 </head>  
 <body> 

 

  <div class="alert alert-success" style="display: none;">
    
  </div>

  <button type="button" id="btnAdd"  data-target="#myModal" class="btn btn-info btn-lg">Add</button>  
                


  

      <div class="container box">  
           <h3 align="center"><?php echo $title; ?></h3><br />  
           <div class="table-responsive">  
                <br />  
                <table  class="table table-bordered table-striped">  
                      <thead>
                          <tr>  

                            <td>Item ID</td>
                           <td>Item Name</td>
                           <td>Brand Name</td>
                           <td>Model Name</td>
                           <td>Date</td>
                           <td>Delete Action</td>
                            
                               
                              
                          </tr> 
                          </thead>
                          <tbody id="user_data">
      
    </tbody> 
                      
                </table>  
           </div>  
      </div>  


  


<div id="myModal" class="modal fade"  role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>

<div class="modal-body">
          <form id="myForm" action="" method="post" class="form-horizontal">
            
            <div class="form-group">
              <label for="name" class="label-control col-md-4">Item ID</label>
              <div class="col-md-8">
                <input type="text" name="txtItemID" class="form-control">
              </div>
            </div>

           <div class="form-group">
              <label for="name" class="label-control col-md-4">Item Name</label>
              <div class="col-md-8">
                <input type="text" name="txtItemName" class="form-control">
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="label-control col-md-4">Brand ID</label>
              <div class="col-md-8">
                <input type="text" name="txtBrandID" class="form-control">
              </div>
            </div>


            <div class="form-group">
              <label for="name" class="label-control col-md-4">Brand Name</label>
              <div class="col-md-8">
                <input type="text" name="txtBrandName" class="form-control">
              </div>
            </div>


            <div class="form-group">
              <label for="name" class="label-control col-md-4">Model ID</label>
              <div class="col-md-8">
                <input type="text" name="txtModelID" class="form-control">
              </div>
            </div>


            <div class="form-group">
              <label for="name" class="label-control col-md-4">Model Name</label>
              <div class="col-md-8">
                <input type="text" name="txtModelName" class="form-control">
              </div>
            </div>

            
          </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnSave" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 




      </body>  
 </html>
    



      




 <script >
   $(function(){
   // $(document).ready(function(){ 
    showAll();

    //Add New
    
   $('#btnAdd').click(function(){
   // alert('tst');
      $('#myModal').modal('show');
      $('#myModal').find('.modal-title').text('Add New Record');
      $('#myForm').attr('action', '<?php echo base_url() ?>crud/addItem');
    });


    $('#btnSave').click(function(){
     // alert('test');
     var url = $('#myForm').attr('action');
      var data = $('#myForm').serialize();
     
      var item_id = $('input[name=txtItemID]');
      var brand_id = $('input[name=txtBrandID]');
      var b_name = $('input[name=txtBrandName]');
      var model_id = $('input[name=txtModelID]');
      var name = $('input[name=txtItemName]');
      var m_name = $('input[name=txtModelName]');

      



      
        $.ajax({
          type: 'ajax',
          method: 'post',
          url:url,
          data: data,
          async: false,
          dataType: 'json',
          success: function(response){
            if(response.success){
              $('#myModal').modal('hide');
              $('#myForm')[0].reset();
              if(response.type=='add'){
                var type = 'added'
              }
              $('.alert-success').html('Item '+type+' successfully').fadeIn().delay(4000).fadeOut('slow');
              showAll();
            }else{
              alert('Error');
            }
          },
          error: function(){
            alert('Could not add data');
          }
        });
      
    });



    


     function showAll(){
      $.ajax({
        type: 'ajax',
        url: 'http://localhost/ci_intro/crud/fetch_user',
        
        dataType: 'json',
        success: function(data){
          
          var html = '';
          var i;
          for(i=0; i<data.length; i++){

            html +='<tr>'+
                  '<td>'+data[i].item_id+'</td>'+
                  '<td>'+data[i].name+'</td>'+
                  '<td>'+data[i].b_name+'</td>'+
                  '<td>'+data[i].m_name+'</td>'+
                  '<td>'+data[i].date_added+'</td>'+

                  
                  '<td>'+


                    
                    '<a href="javascript:;"   class="btn btn-danger item-delete" data="'+data[i].item_id+'">Delete</a>'+
                  '</td>'+
                  '</tr>';
           

          }
          $('#user_data').html(html);
        },
        error: function(){
          alert('Could not get Data from Database');
        }
      });
    

}


//delete- 
    $('#user_data').on('click', '.item-delete', function(){
      var id = $(this).attr('data');
      
      
      if(confirm("Are you sure you want to delete this?"))  
           {  
        $.ajax({
          type: 'ajax',
          method: 'get',
          async: false,
          url: 'http://localhost/ci_intro/crud/deleteItem',
          data:{id:id},
          dataType: 'json',
          success: function(response){
            if(response.success){


              $('.alert-success').html('Item Deleted successfully').fadeIn().delay(4000).fadeOut('slow');
              
              showAll();
            }else{
              alert('Error');
            }
          },
          error: function(){
            alert('Error deleting');
          }
        });
      }

      else  
           {  
                return false;       
           }  
      
    });



    







    




  

  
});




 </script>