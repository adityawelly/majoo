<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Manage Attributes
      <small>Value</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="<?php echo base_url('attributes/') ?>">Attributes</a></li>
      <li class="active">Attributes Value</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box">
          <div class="box-body">
            <h4>Attribute name: <?php echo $attribute_data['name']; ?></h4>
          </div>
        </div>

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

        <?php //if(in_array('createGroup', $user_permission)): 
        ?>
        <button class="btn btn-danger" data-toggle="modal" data-target="#addModal">Add Value</button>
        <br /> <br />
        <?php //endif; 
        ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Attributes Value</h3>
          </div>
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Attribute Value</th>
                  <?php //if(in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)): 
                  ?>
                  <th>Action</th>
                  <?php //endif; 
                  ?>
                </tr>
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>


  </section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Attribute Value</h4>
      </div>

      <form role="form" action="<?php echo base_url('attributes/createValue') ?>" method="post" id="createForm">

        <div class="modal-body">
          <div class="form-group">
            <label for="supplier_name">Attribute Value</label>
            <input type="text" class="form-control" id="attribute_value_name" name="attribute_value_name" placeholder="Enter attribute value" autocomplete="off">
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" name="attribute_parent_id" id="attribute_parent_id" value="<?php echo $attribute_data['id']; ?>">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>


    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Attribute Value</h4>
      </div>

      <form role="form" action="<?php echo base_url('attributes/updateValue') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="edit_supplier_name">Attribute Value</label>
            <input type="text" class="form-control" id="edit_attribute_value_name" name="edit_attribute_value_name" placeholder="Enter attribute value" autocomplete="off">
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" name="attribute_parent_id" id="attribute_parent_id" value="<?php echo $attribute_data['id']; ?>">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>


    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Attribute Value</h4>
      </div>

      <form role="form" action="<?php echo base_url('attributes/removeValue') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div>
  </div>
</div>


<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {



    $("#attributeNav").addClass('active');

    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'attributes/fetchAttributeValueData/' + <?php echo $attribute_data['id']; ?>,
      'order': []
    });

    $("#createForm").unbind('submit').on('submit', function() {
      var form = $(this);

      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {

          manageTable.ajax.reload(null, false);

          if (response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
              '</div>');

            $("#addModal").modal('hide');

            $("#createForm")[0].reset();
            $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

          } else {

            if (response.messages instanceof Object) {
              $.each(response.messages, function(index, value) {
                var id = $("#" + index);

                id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');

                id.after(value);

              });
            } else {
              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        }
      });

      return false;
    });

  });

  function editFunc(id) {

    $.ajax({
      url: base_url + 'attributes/fetchAttributeValueById/' + id,
      type: 'post',
      dataType: 'json',
      success: function(response) {

        console.log(response);

        $("#edit_attribute_value_name").val(response.value);

        $("#updateForm").unbind('submit').bind('submit', function() {
          var form = $(this);

          $(".text-danger").remove();

          $.ajax({
            url: form.attr('action') + '/' + id,
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {

              manageTable.ajax.reload(null, false);

              if (response.success === true) {
                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                  '</div>');

                $("#editModal").modal('hide');
                $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

              } else {

                if (response.messages instanceof Object) {
                  $.each(response.messages, function(index, value) {
                    var id = $("#" + index);

                    id.closest('.form-group')
                      .removeClass('has-error')
                      .removeClass('has-success')
                      .addClass(value.length > 0 ? 'has-error' : 'has-success');

                    id.after(value);

                  });
                } else {
                  $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                    '</div>');
                }
              }
            }
          });

          return false;
        });

      }
    });
  }

  function removeFunc(id) {
    if (id) {
      $("#removeForm").on('submit', function() {

        var form = $(this);

        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            attribute_value_id: id
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