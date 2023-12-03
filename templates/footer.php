  <script src="../assets/lib/jquery/jquery.js"></script>
  <script src="../assets/lib/popper.js/popper.js"></script>
  <script src="../assets/lib/bootstrap/bootstrap.js"></script>
  <script src="../assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
  <script src="../assets/lib/highlightjs/highlight.pack.js"></script>
  <script src="../assets/lib/datatables/jquery.dataTables.js"></script>
  <script src="../assets/lib/datatables-responsive/dataTables.responsive.js"></script>
  <script src="../assets/lib/select2/js/select2.min.js"></script>
  <script src="../assets/js/starlight.js"></script>
  <script>
    $(document).ready(function() {
      <?php echo $script; ?>
    });
  </script>
  <script>
    $(document).ready(function() {
      $('body').on('click', 'a[data-action="signout"]', function(e) {
        e.preventDefault();

        $.ajax({
          url: 'process.php',
          method: 'POST',
          data: {
            action: 'signout'
          },
          dataType: 'json',
          success: function(response) {
            console.log(response);
            window.location.href = '../index.php';
          },
          error: function(xhr, status, error) {
            console.error('Error while signing out:', error);
          }
        });
      });
    });
  </script>
  </body>

  </html>