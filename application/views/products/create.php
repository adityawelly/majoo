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

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Add Product</h3>
          </div>
          <form role="form" action="<?php base_url('products/create') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">

                <label for="product_image">Product Image</label>
                <div class="kv-avatar">
                  <div class="file-loading">
                    <input id="product_image" name="product_image" type="file">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" autocomplete="off" />
              </div>

              <div class="form-group">
                <label for="description">Product Description</label>
                <textarea type="text" class="form-control" id="description" name="description" placeholder="Product Description" autocomplete="off">
                  </textarea>
              </div>

              <div class="form-group">
                <label for="price">Product Price</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" autocomplete="off" />
              </div>

              <div class="form-group">
                <label for="category">Product Category</label>
                <select class="form-control select_group" id="category" name="category[]" multiple="multiple">
                  <?php foreach ($category as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <!-- <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter sku" autocomplete="off" />
              </div> -->

              <!-- <div class="form-group">
                <label for="qty">Qty</label>
                <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty" autocomplete="off" />
              </div> -->

              <?php if ($attributes) : ?>
                <?php foreach ($attributes as $k => $v) : ?>
                  <div class="form-group">
                    <label for="groups"><?php echo $v['attribute_data']['name'] ?></label>
                    <select class="form-control select_group" id="attributes_value_id" name="attributes_value_id[]" multiple="multiple">
                      <?php foreach ($v['attribute_value'] as $k2 => $v2) : ?>
                        <option value="<?php echo $v2['id'] ?>"><?php echo $v2['value'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                <?php endforeach ?>
              <?php endif; ?>

              <div class="form-group">
                <label for="suppliers">Supplier</label>
                <select class="form-control select_group" id="suppliers" name="suppliers[]" multiple="multiple">
                  <?php foreach ($suppliers as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <!-- <div class="form-group">
                <label for="store">Store</label>
                <select class="form-control select_group" id="store" name="store">
                  <?php foreach ($stores as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div> -->

              <div class="form-group">
                <label for="store">Availability</label>
                <select class="form-control" id="availability" name="availability">
                  <option value="1">Yes</option>
                  <option value="2">No</option>
                </select>
              </div>

            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-danger">Save</button>
              <a href="<?php echo base_url('products/') ?>" class="btn btn-danger">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>

  </section>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainProductNav").addClass('active');
    $("#addProductNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
      'onclick="alert(\'Call your custom code here.\')">' +
      '<i class="glyphicon glyphicon-tag"></i>' +
      '</button>';
    $("#product_image").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      browseLabel: '',
      removeLabel: '',
      browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
      removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
      removeTitle: 'Cancel or reset changes',
      elErrorContainer: '#kv-avatar-errors-1',
      msgErrorClass: 'alert alert-block alert-danger',
      // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
      layoutTemplates: {
        main2: '{preview} ' + btnCust + ' {remove} {browse}'
      },
      allowedFileExtensions: ["jpg", "png", "gif"]
    });

  });
</script>