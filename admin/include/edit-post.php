<?php

//-Data pulled from DB form fields

if(isset($_GET['p-id'])) {

    $post_data = $_GET['p-id'];

    $query = " SELECT * FROM posts WHERE post_id= $post_data ";
    $pull_post_data = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($pull_post_data)) {

        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_image = $row['post_image'];
        $post_category = $row['post_category_id'];
        $post_article = $row['post_article'];
    }

}

//- Edited data passed to DB for edit

    if(isset($_POST["update-post"])) {

      if(check_user_role()){
    
        $post_title = $_POST['title'];
        $post_author = $_POST['author'];
        $post_category = $_POST['category-id'];
        $post_article = $_POST['article'];

        $query = "UPDATE posts SET ";
            $query .= "post_title = '{$post_title}', ";
            $query .= "post_author = '{$post_author}', ";
            $query .= "post_category_id = {$post_category}, ";
            $query .= "post_article = '{$post_article}' ";
        
            $query .= "WHERE post_id = {$post_id} ";
      
        $update_DB = mysqli_query($connection, $query);

        if(!$update_DB){
          die("QUERY FAILED" . mysqli_error($connection));
        }
        else {
          flashMsg('success', 'Post Updated');
          header("Location: /post.php?p-id={$post_id}");
          exit;    
        }
        
      }
    }
?>


<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="title">Title</label>
                    <input value="<?php echo $post_title ?>" type="text" class="form-control" name="title" placeholder="title">
                  </div>

                  <div class="form-group">
                    <label for="author">Author</label>
                    <input value="<?php echo $post_author ?>"type="text" class="form-control" name="author" placeholder="author">
                  </div>

                  <div class="form-group">
                    <label for="category-id">Category</label>
                    <input value="<?php echo $post_category ?>" type="text" class="form-control" name="category-id" placeholder="title">
                  </div>

                  <!-- Image field needed -->

                  <img style="max-width:300px;" src="<?php if($post_image){
                      echo "images/". $post_image;}
                      else echo "img/placeholder.png"?>" alt="">
                

                  <div class="form-group">
                    <label for="image">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Change file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" name="">Upload</span>
                      </div>
                    </div>
                  </div>

                                <div class="mb-3">
                <textarea class="textarea" name="article"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $post_article ?></textarea>
              </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="update-post" class="btn btn-primary">Submit</button>
                </div>
              </form>
</div>
<!-- /.card -->