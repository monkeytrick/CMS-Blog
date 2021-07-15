<?php 

  if(isset($_POST['create-post'])) {

    $post_title = $_POST['title'];
    $post_author = $_SESSION['username'];
    $post_category_id = $_POST['category-id'];
   
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_article = strip_tags($_POST['article']);

    $post_date = date('d-m-y');
    $post_status = $_POST['post-status'];

    move_uploaded_file($post_image_temp,"../images/$post_image");
    $stmt = mysqli_prepare($connection, "INSERT INTO posts (post_title, post_author, post_category_id, post_article, post_image, post_date, post_comment_count, post_status, view_count, post_likes) VALUES (?,?,?,?,?,now(),0,?,0,0)");
    mysqli_stmt_bind_param($stmt, 'ssisss', $post_title, $post_author, $post_category_id, $post_article, $post_image, $post_status);

    mysqli_stmt_execute($stmt);

    //Gets ID of post just inserted
    $new_ID = $connection->insert_id;

    // var_dump($new_ID);
    // exit;
    flashMsg('success', 'Post Created!');
    header("Location: /post.php?p-id={$new_ID}");
    exit;

    if(!$stmt){
      die("QUERY FAILED" . mysqli_error($connection));
  }

 }
 
?>



<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">New Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" placeholder="title" required>
                  </div>

                  <div class="form-group">
                    <label for="category-id">Category</label>
                    <input type="text" class="form-control" name="category-id" placeholder="title" required>
                  </div>

                  <div class="form-group">
                    <label for="image">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" name="">Upload</span>
                      </div>
                    </div>
                  </div>

                <div class="mb-3">
                <div class="form-group">
                <textarea class="textarea" placeholder="article" name="article"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
                <div class="form-group" style="max-width: 10%">
                    <label for="post-status">Status</label>
                    <!-- <input type="text" class="form-control" name="post-status"> -->

                      <select name="post-status" class="form-control" class="width: 200px;">
                        <option value="draft">Draft</option>
                        <option value="publish">Publish</option>
                      </select>
                </div>
              
                </div>
                </div>

                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="create-post" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>

</script>


