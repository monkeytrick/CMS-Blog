 <!-- Main Footer -->
 <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- Toastr flash messages -->
<script src="../js/toastr.min.js"></script>


<!-- Approve, unapprove and delete comments with AJAX -->
<script>

var value = "";
let eleId = null;

window.onload = () => {
  let iconClass = [...document.getElementsByClassName('icon-call')];

  iconClass.forEach(icon => 
    icon.addEventListener('click', () => {
      value = value.concat(event.target.classList[0], "=", event.target.id);
      eleId = event.target.id;
      //MAKE AJAX CALL
      ajaxCall(value);    
    })
  )
}

function ajaxCall(value) {
  let xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
    // console.log(this.responseText);
    //Remove any white spaces from response
    console.log(this.responseText.trim());
    let returnVal = this.responseText.trim();
    console.log(returnVal);
    modifyIcon(returnVal);
    }
  }

  xhttp.open("POST", 'include/ajax.php', true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.responseType = "";  
  xhttp.send(value);
}

function modifyIcon(returnVal){
  let elModif = document.getElementById(eleId);

  if(returnVal == "approved"){
    elModif.className = "unapprove far fa-times-circle icon-call";
    elModif.setAttribute("style", "color: #ffc107; padding-right: 25%");
    // addList(elModif);
  }
  else if(returnVal == "unapproved"){
    elModif.className = "approve fa fa-check icon-call";
    elModif.setAttribute("style", "color: green; padding-right: 25%");
    // addList(elModif);
  }
  else if(returnVal == "deleted"){
    let parentEl = elModif.parentNode;
    parentEl.parentNode.remove();
    toastr.warning("Post Deleted");
  }

  eleId = null;
  value ="";
}
</script>

<!-- <script src="js/toastr.min.js"></script> -->

  <script>
      toastr.options = {
        "showDuration": "30",
        "hideDuration": "10",
        "timeOut": "1000",
      }

      <?php 
         if(isset($_SESSION['flash'])) {
          echo "toastr." . $_SESSION['flash'];
          unset($_SESSION['flash']);
        }
      ?>
  </script>


</body>
</html>

