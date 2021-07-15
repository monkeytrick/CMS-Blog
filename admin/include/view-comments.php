
      <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
 
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                     <th>COMMENT Date</th>  
                    <th>COMMENT AUTHOR</th>
                    <th>POST TITLE</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                            $get_comments = " SELECT * FROM comments ORDER BY comment_date DESC";
                            $returned_comments = mysqli_query($connection, $get_comments);
                            while($comment = mysqli_fetch_assoc($returned_comments)) {
                               
                                    $comment_date = $comment['comment_date'];
                                    $comment_id = $comment['comment_id'];
                                    $comment_author = $comment['comment_author'];
                                    $comment_post_id = $comment['comment_post_id']; 
                                    $comment_status = $comment['comment_status'];

                              echo "<tr>";
                                  echo "<td>$comment_date</td>";
                                  echo "<td>$comment_author</td>";

                              $title_query = "SELECT post_title FROM posts WHERE post_id = $comment_post_id limit 1";
                              $get_title = mysqli_query($connection, $title_query);

                              $value = $get_title->fetch_row()[0] ?? false;

                                  if($value){
                                  echo "<td>$value</td>";
                                  } else {
                                    echo "<td>POST DELETED</td>";
                                  }

                                  echo "<td>$comment_status</td>";
                                  echo "<td>";
                                //    if($comment_status == "Unapproved"){
                                //      echo "<a href='comments.php?approve=$comment_id'><i class='fa fa-check' aria-hidden='true' style='color: green; padding-right: 25%'></i></a>";}
                                //    else {
                                //   echo "<a href='comments.php?unapprove=$comment_id'><i class='far fa-times-circle' style='color: #ffc107; padding-right: 25%'></i></a>";
                                //       };  
                                //  echo "<a href='comments.php?delete={$comment_id}'><i class='fas fa-trash-alt' style='color: #dc3545'></i></a></td>";                             
                                //   echo "</tr>";

                                if($comment_status == "Unapproved"){
                                  echo "<i id='$comment_id' class='approve fa fa-check icon-call' aria-hidden='true' style='color: green; padding-right: 25%'></i>";}
                                else {
                               echo "<i id='$comment_id' class='unapprove far fa-times-circle icon-call' style='color: #ffc107; padding-right: 25%'></i>";
                                   };  
                              echo "<i id='$comment_id' class='delete fas fa-trash-alt icon-call' style='color: #dc3545'></i></a></td>";                             
                               echo "</tr>";
                                
                            };
                    ?>

                
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

    <!-- /.content -->
<!-- ./wrapper -->


