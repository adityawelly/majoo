<?php
class Login_model extends CI_Model
{
	function ceklogin($email, $password)
	{
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$query = $this->db->get('tblm_user');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
}
