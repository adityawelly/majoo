<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">

      <li id="dashboardMainMenu">
        <a href="<?php echo base_url('dashboard') ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <?php if ($user_permission) : ?>
        <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
          <li id="mainUserNav">
            <a href="<?php echo base_url('users') ?>">
              <i class="fa fa-users"></i> <span>Users</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)) : ?>
          <li id="mainProductNav">
            <a href="<?php echo base_url('products') ?>">
              <i class="fa fa-cube"></i> <span>Products</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)) : ?>
          <li id="mainOrdersNav">
            <a href="<?php echo base_url('orders') ?>">
              <i class="fa fa-dollar"></i> <span>Orders</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (in_array('createSupplier', $user_permission) || in_array('updateSupplier', $user_permission) || in_array('viewSupplier', $user_permission) || in_array('deleteSupplier', $user_permission)) : ?>
          <li id="supplierNav">
            <a href="<?php echo base_url('suppliers/') ?>">
              <i class="glyphicon glyphicon-tags"></i> <span>Supplier</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)) : ?>
          <li id="categoryNav">
            <a href="<?php echo base_url('category/') ?>">
              <i class="fa fa-files-o"></i> <span>Category</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (in_array('viewReports', $user_permission)) : ?>
          <li id="reportNav">
            <a href="<?php echo base_url('reports/') ?>">
              <i class="glyphicon glyphicon-stats"></i> <span>Reports</span>
            </a>
          </li>
        <?php endif; ?>

      <?php endif; ?>
      <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

    </ul>
  </section>
</aside>