<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->not_logged_in();

    $this->data['page_title'] = 'Products';

    $this->load->model('model_products');
    $this->load->model('model_suppliers');
    $this->load->model('model_category');
    $this->load->model('model_stores');
    $this->load->model('model_attributes');
  }

  public function index()
  {
    if (!in_array('viewProduct', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    $this->render_template('products/index', $this->data);
  }

  public function fetchProductData()
  {
    $result = array('data' => array());
    $data = $this->model_products->getProductData();
    foreach ($data as $key => $value) {
      $store_data = $this->model_stores->getStoresData($value['store_id']);
      $buttons = '';
      if (in_array('updateProduct', $this->permission)) {
        $buttons .= '<a href="' . base_url('products/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
      }

      if (in_array('deleteProduct', $this->permission)) {
        $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
      }


      $img = '<img src="' . base_url($value['image']) . '" alt="' . $value['name'] . '" class="img-circle" width="50" height="50" />';

      $availability = ($value['availability'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

      $qty_status = '';
      if ($value['qty'] <= 10) {
        $qty_status = '<span class="label label-warning">Low !</span>';
      } else if ($value['qty'] <= 0) {
        $qty_status = '<span class="label label-danger">Out of stock !</span>';
      }

      $result['data'][$key] = array(
        $img,
        // $value['sku'],
        $value['name'],
        $value['price'],
        // $value['qty'] . ' ' . $qty_status,
        // $store_data['name'],
        $availability,
        $buttons
      );
    }

    echo json_encode($result);
  }

  public function create()
  {
    if (!in_array('createProduct', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
    // $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
    $this->form_validation->set_rules('price', 'Price', 'trim|required');
    // $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
    // $this->form_validation->set_rules('store', 'Store', 'trim|required');
    $this->form_validation->set_rules('availability', 'Availability', 'trim|required');


    if ($this->form_validation->run() == TRUE) {
      // true case
      $upload_image = $this->upload_image();

      $data = array(
        'name' => $this->input->post('product_name'),
        // 'sku' => $this->input->post('sku'),
        'price' => $this->input->post('price'),
        // 'qty' => $this->input->post('qty'),
        'image' => $upload_image,
        'description' => $this->input->post('description'),
        'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
        'supplier_id' => json_encode($this->input->post('suppliers')),
        'category_id' => json_encode($this->input->post('category')),
        // 'store_id' => $this->input->post('store'),
        'availability' => $this->input->post('availability'),
      );

      $create = $this->model_products->create($data);
      if ($create == true) {
        $this->session->set_flashdata('success', 'Data Successfully Created');
        redirect('products/', 'refresh');
      } else {
        $this->session->set_flashdata('errors', 'Error occurred!!');
        redirect('products/create', 'refresh');
      }
    } else {
      // false case

      // attributes 
      $attribute_data = $this->model_attributes->getActiveAttributeData();

      $attributes_final_data = array();
      foreach ($attribute_data as $k => $v) {
        $attributes_final_data[$k]['attribute_data'] = $v;

        $value = $this->model_attributes->getAttributeValueData($v['id']);

        $attributes_final_data[$k]['attribute_value'] = $value;
      }

      $this->data['attributes'] = $attributes_final_data;
      $this->data['suppliers'] = $this->model_suppliers->getActiveSuppliers();
      $this->data['category'] = $this->model_category->getActiveCategroy();
      $this->data['stores'] = $this->model_stores->getActiveStore();

      $this->render_template('products/create', $this->data);
    }
  }

  public function upload_image()
  {
    // assets/images/product_image
    $config['upload_path'] = 'assets/images/product_image';
    $config['file_name'] =  uniqid();
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '1000';

    // $config['max_width']  = '1024';s
    // $config['max_height']  = '768';

    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('product_image')) {
      $error = $this->upload->display_errors();
      return $error;
    } else {
      $data = array('upload_data' => $this->upload->data());
      $type = explode('.', $_FILES['product_image']['name']);
      $type = $type[count($type) - 1];

      $path = $config['upload_path'] . '/' . $config['file_name'] . '.' . $type;
      return ($data == true) ? $path : false;
    }
  }

  public function update($product_id)
  {
    if (!in_array('updateProduct', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    if (!$product_id) {
      redirect('dashboard', 'refresh');
    }

    $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
    // $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
    $this->form_validation->set_rules('price', 'Price', 'trim|required');
    // $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
    // $this->form_validation->set_rules('store', 'Store', 'trim|required');
    $this->form_validation->set_rules('availability', 'Availability', 'trim|required');

    if ($this->form_validation->run() == TRUE) {

      $data = array(
        'name' => $this->input->post('product_name'),
        // 'sku' => $this->input->post('sku'),
        'price' => $this->input->post('price'),
        // 'qty' => $this->input->post('qty'),
        'description' => $this->input->post('description'),
        'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
        'supplier_id' => json_encode($this->input->post('suppliers')),
        'category_id' => json_encode($this->input->post('category')),
        // 'store_id' => $this->input->post('store'),
        'availability' => $this->input->post('availability'),
      );


      if ($_FILES['product_image']['size'] > 0) {
        $upload_image = $this->upload_image();
        $upload_image = array('image' => $upload_image);

        $this->model_products->update($upload_image, $product_id);
      }

      $update = $this->model_products->update($data, $product_id);
      if ($update == true) {
        $this->session->set_flashdata('success', 'Data Successfully Updated');
        redirect('products/', 'refresh');
      } else {
        $this->session->set_flashdata('errors', 'Error occurred!!');
        redirect('products/update/' . $product_id, 'refresh');
      }
    } else {
      $attribute_data = $this->model_attributes->getActiveAttributeData();

      $attributes_final_data = array();
      foreach ($attribute_data as $k => $v) {
        $attributes_final_data[$k]['attribute_data'] = $v;

        $value = $this->model_attributes->getAttributeValueData($v['id']);

        $attributes_final_data[$k]['attribute_value'] = $value;
      }
      $this->data['attributes'] = $attributes_final_data;
      $this->data['suppliers'] = $this->model_suppliers->getActiveSuppliers();
      $this->data['category'] = $this->model_category->getActiveCategroy();
      $this->data['stores'] = $this->model_stores->getActiveStore();

      $product_data = $this->model_products->getProductData($product_id);
      $this->data['product_data'] = $product_data;
      $this->render_template('products/edit', $this->data);
    }
  }
  public function remove()
  {
    if (!in_array('deleteProduct', $this->permission)) {
      redirect('dashboard', 'refresh');
    }

    $product_id = $this->input->post('product_id');

    $response = array();
    if ($product_id) {
      $delete = $this->model_products->remove($product_id);
      if ($delete == true) {
        $response['success'] = true;
        $response['messages'] = "Successfully removed";
      } else {
        $response['success'] = false;
        $response['messages'] = "Error in the database while removing the product information";
      }
    } else {
      $response['success'] = false;
      $response['messages'] = "Refersh the page again!!";
    }
    echo json_encode($response);
  }
}
