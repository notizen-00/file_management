<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * This file is part of Auth_Ldap.

Auth_Ldap is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Auth_Ldap is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Auth_Ldap.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * @author      Greg Wojtak <greg.wojtak@gmail.com>
 * @copyright   Copyright © 2010,2011 by Greg Wojtak <greg.wojtak@gmail.com>
 * @package     Auth_Ldap
 * @subpackage  auth demo
 * @license     GNU Lesser General Public License
 */
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('Form_validation');
        $this->load->library('auth_ldap');
        $this->load->helper('url');
        $this->load->library('table');
    }

    public function index()
    {
        $this->session->keep_flashdata('tried_to');
        $this->login();
    }

    public function login($errorMsg = null)
    {
        $this->session->keep_flashdata('tried_to');
        if (!$this->auth_ldap->is_authenticated()) {

            $rules = $this->form_validation;
            $rules->set_rules('username', 'Username', 'required|alpha_dash');
            $rules->set_rules('password', 'Password', 'required');

            if ($rules->run() && $this->auth_ldap->login(
                $rules->set_value('username'),
                $rules->set_value('password'))) {

                if ($this->session->flashdata('tried_to')) {
                    redirect($this->session->flashdata('tried_to'));
                } else {
                    redirect('/portal/');
                }
            } else {
                // Login FAIL
                $this->load->view('auth/login_form', array('login_fail_msg' => 'Error with LDAP authentication.'));
            }
        } else {
            // Already logged in...
            redirect('/portal/');
        }
    }

    public function logout()
    {
        if ($this->session->userdata('logged_in')) {
            $data['name'] = $this->session->userdata('cn');
            $data['username'] = $this->session->userdata('username');
            $data['logged_in'] = true;
            $this->auth_ldap->logout();
        } else {
            $data['logged_in'] = false;
        }
        $this->load->view('auth/logout_view', $data);
    }
}