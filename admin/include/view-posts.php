<?php include "modal_confirm" ?>

 <?php


    if(isset($_POST['checkBoxArray'])){
      foreach($_POST['checkBoxArray'] as $checkBoxValue ){        
        $bulk_apply = $_POST['bulk-apply'];

        if($bulk_apply == "publish" || $bulk_apply == "draft" ){
          $query = " UPDATE posts SET post_status = '{$bulk_apply}' WHERE post_id = $checkBoxValue ";
          $update_status_query = mysqli_query($connection, $query);
          if(!$update_status_query){
            die("ERROR " . mysqli_error($connection));
          }

        }
        elseif($bulk_apply == "delete"){
          $query = " DELETE FROM posts WHERE post_id = $checkBoxValue ";
          $update_status_query = mysqli_query($connection, $query);
          if(!$update_status_query){
            die("ERROR " . mysqli_error($connection));
          }
        
        }
      }
    };


?>
 
 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <form action="" method="post">

                <table id="example2" class="table table-bordered table-hover">

                  <div id="checkBox-area" class="form-group">

                    <select name="bulk-apply" id="">
                      <option value="">Select Options</option>
                      <option value="publish">Publish</option>
                      <option value="draft">Draft</option>
                      <option value="delete">Delete</option>
                   
                    </div>

                  </select>
                  <button type="submit" name="apply" class="btn btn-primary">Apply</button>

                  <thead>
                  <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Comments</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                            $getPosts = "SELECT * FROM posts";
                            $returnedPosts = mysqli_query($connection, $getPosts);
                            while($post = mysqli_fetch_assoc($returnedPosts)) {
                                echo "<tr>
                                <td><input type='checkbox' class='checkedBox' name='checkBoxArray[]' value={$post['post_id']}></td>
                                <td><a href='post.php?p-id=$post[post_id]'>{$post['post_title']}</a></td>
                                <td>{$post['post_author']}
                                </td>
                                <td>{$post['post_date']}</td>
                                <td>{$post['post_status']}</td>
                                <td>{$post['post_comment_count']}</td>
                                <td>    
                                    <a href='posts.php?source=edit-post&p-id={$post['post_id']}'>Edit</a>
                                </td>    
                                <td>
                                    <a data-toggle='modal' data-target='#exampleModal' class='deleteSelectors' id={$post['post_id']} href='posts.php?delete={$post['post_id']}'>Delete</a>
                                </td>
                                </tr> ";
                                };
                    ?>
                 
                  </tbody>
                </table>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>

      <!-- /.container-fluid -->
    </section>

         <a href="posts.php?source=add-post"><button class="btn btn-primary">Add New</button></a>
    
<script>
    var selector = document.getElementById("selectAll"); 
    selector.addEventListener('click', function(){
      var boxes = document.getElementsByClassName('checkedBox');
        var fillBox = null;
        if(selector.checked == true) {
          fillBox = true;
        }
        else {
          fillBox = false;
        }
        for(i=0; i <= boxes.length; i++){        
           boxes[i].checked = fillBox;
        }
    });     
</script>

<script>

    window.onload = () => {

      let deleteID = " ";

      let deleteConfirm = document.getElementById("deleteConfirm");     
      
      let deleteSelectors = document.getElementsByClassName("deleteSelectors");
        for(i=0; i <= deleteSelectors.length; i++) {
          deleteSelectors[i].addEventListener('click', ()=> {
          deleteID = "posts.php?delete=" + event.srcElement.id;
          deleteConfirm.setAttribute("href", deleteID)
           });
           };

    };

  </script>