<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->load->model('login_model');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login');
		} else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$ceklogin = $this->login_model->ceklogin($email, $password);
			if ($ceklogin) {
				$data = array(
					'email'  => $ceklogin->email,
					'id'     => $ceklogin->rid,
					'logged_in' => TRUE
				);

				$this->session->set_userdata($data);
				redirect(base_url('dashboard'));
			} else {
				$this->session->set_flashdata('error', 'Email/Password salah!');
				redirect(base_url('login'));
			}
		}
	}
}
