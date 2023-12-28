<script src="../assets/lib/jquery/jquery.js"></script>
  <script src="../assets/lib/popper.js/popper.js"></script>
  <script src="../assets/lib/bootstrap/bootstrap.js"></script>
  <script src="../assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
  <script src="../assets/lib/highlightjs/highlight.pack.js"></script>
  <script src="../assets/lib/datatables/jquery.dataTables.js"></script>
  <script src="../assets/lib/datatables-responsive/dataTables.responsive.js"></script>
  <script src="../assets/lib/select2/js/select2.min.js"></script>
  <script src="../assets/js/starlight.js"></script>
  <script><?php echo $script; ?></script>
  <script>
    function showAlert(type, message) {
        var alertClasses = {
          'success': 'alert-success',
          'error': 'alert-danger',
          'info': 'alert-info',
          'warning': 'alert-warning',
          'primary': 'alert-primary',
          'secondary': 'alert-secondary'
        };
  
        var alertClass = alertClasses[type] || 'alert-info';
        var alertHtml = '<div class=\"alert ' + alertClass + ' alert-dismissible fade show\" role=\"alert\">' +
            message +
            '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">' +
            '<span aria-hidden=\"true\">&times;</span>' +
            '</button>' +
            '</div>';
        // Append the alert to a container (e.g., a div with id=\"alerts\")
        $('#alerts').html(alertHtml);
    }
  </script>
  </body>
</html>