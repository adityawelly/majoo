<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Products
      <small>Management</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if ($this->session->flashdata('success')) : ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif ($this->session->flashdata('error')) : ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <?php if (in_array('createProduct', $user_permission)) : ?>
          <a href="<?php echo base_url('products/create') ?>" class="btn btn-danger">Add Product</a>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Products</h3>
          </div>
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Image</th>
                  <!-- <th>SKU</th> -->
                  <th>Product Name</th>
                  <th>Price</th>
                  <!-- <th>Qty</th> -->
                  <!-- <th>Store</th> -->
                  <th>Availability</th>
                  <?php if (in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)) : ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php if (in_array('deleteProduct', $user_permission)) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Remove Product</h4>
        </div>

        <form role="form" action="<?php echo base_url('products/remove') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Do you really want to remove?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>



<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {

    $("#mainProductNav").addClass('active');

    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'products/fetchProductData',
      'order': []
    });

  });

  function removeFunc(id) {
    if (id) {
      $("#removeForm").on('submit', function() {

        var form = $(this);

        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            product_id: id
          },
          dataType: 'json',
          success: function(response) {

            manageTable.ajax.reload(null, false);

            if (response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                '</div>');

              $("#removeModal").modal('hide');

            } else {

              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        });

        return false;
      });
    }
  }
</script>