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
 * Auth_Ldap Class
 *
 * Simple LDAP Authentication library for Code Igniter.
 *
 * @package         Auth_Ldap
 * @author          Greg Wojtak <greg.wojtak@gmail.com>
 * @link            http://github.com/gwojtak/Auth_Ldap.git
 * @license         GNU Lesser General Public License (LGPL)
 * @copyright       Copyright © 2010,2011 by Greg Wojtak <greg.wojtak@gmail.com>
 * @todo            Allow for privileges in groups of groups in AD
 * @todo            Rework roles system a little bit to a "auth level" paradigm
 */
class Auth_Ldap
{
    public function __construct()
    {
        $this->ci = &get_instance();

        log_message('debug', 'Auth_Ldap initialization commencing...');

        // Load the session library
        $this->ci->load->library('session');

        // Load the configuration
        $this->ci->load->config('auth_ldap');

        // Load the language file
        // $this->ci->lang->load('auth_ldap');

        $this->_init();
    }

    /**
     * @access private
     * @return void
     */
    private function _init()
    {

        // Verify that the LDAP extension has been loaded/built-in
        // No sense continuing if we can't
        if (!function_exists('ldap_connect')) {
            show_error('LDAP functionality not present.  Either load the module ldap php module or use a php with ldap support compiled in.');
            log_message('error', 'LDAP functionality not present in php.');
        }

        $this->ldap_uris = $this->ci->config->item('ldap_uris');
        $this->use_tls = $this->ci->config->item('use_tls');
        $this->basedn = $this->ci->config->item('basedn');
        $this->account_ou = $this->ci->config->item('account_ou');
        $this->login_attribute = $this->ci->config->item('login_attribute');
        $this->use_ad = $this->ci->config->item('use_ad');
        $this->ad_domain = $this->ci->config->item('ad_domain');
        $this->proxy_user = $this->ci->config->item('proxy_user');
        $this->proxy_pass = $this->ci->config->item('proxy_pass');
        $this->roles = $this->ci->config->item('roles');
        $this->auditlog = $this->ci->config->item('auditlog');
        $this->member_attribute = $this->ci->config->item('member_attribute');
    }

    /**
     * @access public
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login($username, $password)
    {
        /*
         * For now just pass this along to _authenticate.  We could do
         * something else here before hand in the future.
         */

        $user_info = $this->_authenticate($username, $password);
        // if (empty($user_info['role'])) {
        //     log_message('info', $username . " has no role to play.");
        //     show_error($username . ' succssfully authenticated, but is not allowed because the username was not found in an allowed access group.');
        // }
        log_message('info', 'User info: ' . print_r($user_info, true));
        // Record the login
        $this->_audit('User info Now: ' . print_r($user_info, true));

        // Set the session data
        $customdata = array('username' => $username,
            'cn' => $user_info['cn'],
            'role' => $user_info['role'],
            'name' => $user_info['name'],
            'office' => $user_info['office'],
            'logged_in' => true);

        $this->ci->session->set_userdata($customdata);
        return true;
    }

    /**
     * @access public
     * @return bool
     */
    public function is_authenticated()
    {
        if ($this->ci->session->userdata('logged_in')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @access public
     */
    public function logout()
    {
        // Just set logged_in to FALSE and then destroy everything for good measure
        $this->ci->session->set_userdata(array('logged_in' => false));
        $this->ci->session->sess_destroy();
    }

    /**
     * @access private
     * @param string $msg
     * @return bool
     */
    private function _audit($msg)
    {
        $date = date('Y/m/d H:i:s');
        if (!file_put_contents($this->auditlog, $date . ": " . $msg . "\n", FILE_APPEND)) {
            log_message('info', 'Error opening audit log ' . $this->auditlog);
            return false;
        }
        return true;
    }

    /**
     * @access private
     * @param string $username
     * @param string $password
     * @return array
     */
    private function _authenticate($username, $password)
    {
        $needed_attrs = array('dn', 'cn', $this->login_attribute);

        foreach ($this->ldap_uris as $uri) {
            $this->ldapconn = ldap_connect($uri);
            if ($this->ldapconn) {
                $this->connected_uri = $uri;
                break;
            } else {
                log_message('info', 'Error connecting to ' . $uri);
            }
        }
        // At this point, $this->ldapconn should be set.  If not... DOOM!
        if (!$this->ldapconn) {
            log_message('error', "Couldn't connect to any LDAP servers.  Bailing...");
            show_error('Error connecting to your LDAP server(s).  Please check the connection and try again.');
        }

        if ($this->use_tls) {
            log_message('info', 'Attempting to start TLS');
            if (substr($this->connected_uri, 0, 5) === 'ldaps') {
                log_message('error', 'TLS is incompatible with ldaps.  Either use ldap:// uri or use_tls = false');
                show_error('TLS incompatible with ldaps.  Use ldap:// uri or use_tls = false');
            }
            ldap_start_tls($this->ldapconn);
        }

        // We've connected, now we can attempt the login...

        // These to ldap_set_options are needed for binding to AD properly
        // They should also work with any modern LDAP service.
        ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

        // Find the DN of the user we are binding as
        // If proxy_user and proxy_pass are set, use those, else bind anonymously
        if ($this->proxy_user) {
            $bind = ldap_bind($this->ldapconn, $this->proxy_user, $this->proxy_pass);
        } else {
            $bind = ldap_bind($this->ldapconn);
        }

        if (!$bind) {
            log_message('error', 'Unable to perform anonymous/proxy bind');
            show_error('Unable to bind for user id lookup');
        }

        log_message('debug', 'Successfully bound to directory.  Performing dn lookup for ' . $username);
        $filter = '(' . $this->login_attribute . '=' . $username . ')';
        $search = ldap_search($this->ldapconn, $this->basedn, $filter);
        $entries = ldap_get_entries($this->ldapconn, $search);
        $binddn = $entries[0]['dn'];
        $this->_audit("User info: " . print_r($entries, true));

        // Now actually try to bind as the user
        $bind = ldap_bind($this->ldapconn, $binddn, $password);
        if (!$bind) {
            $this->_audit("Failed login attempt: " . $username . " from " . $_SERVER['REMOTE_ADDR']);
            return false;
        }
        $cn = $entries[0]['cn'][0];
        $dn = stripslashes($entries[0]['dn']);
        $id = $entries[0][$this->login_attribute][0];

        $get_role_arg = $id;

        return array('cn' => $cn, 'dn' => $dn, 'id' => $id,
            'name' => $entries[0]['sn'][0],
            'office' => $entries[0]['physicaldeliveryofficename'][0],
            'role' => $this->_get_role($get_role_arg));
    }

    /**
     * @access private
     * @param string $str
     * @param bool $for_dn
     * @return string
     */
    private function ldap_escape($str, $for_dn = false)
    {
        /**
         * This function courtesy of douglass_davis at earthlink dot net
         * Posted in comments at
         * http://php.net/manual/en/function.ldap-search.php on 2009/04/08
         */
        // see:
        // RFC2254
        // http://msdn.microsoft.com/en-us/library/ms675768(VS.85).aspx
        // http://www-03.ibm.com/systems/i/software/ldap/underdn.html

        if ($for_dn) {
            $metaChars = array(',', '=', '+', '<', '>', ';', '\\', '"', '#');
        } else {
            $metaChars = array('*', '(', ')', '\\', chr(0));
        }

        $quotedMetaChars = array();
        foreach ($metaChars as $key => $value) {
            $quotedMetaChars[$key] = '\\' . str_pad(dechex(ord($value)), 2, '0');
        }

        $str = str_replace($metaChars, $quotedMetaChars, $str); //replace them
        return ($str);
    }

    /**
     * @access private
     * @param string $username
     * @return int
     */
    private function _get_role($username)
    {
        $filter = '(' . $this->member_attribute . '=' . $username . ')';
        $search = ldap_search($this->ldapconn, $this->basedn, $filter);
        if (!$search) {
            log_message('error', "Error searching for group: " . ldap_error($this->ldapconn));
            show_error('Couldn\'t find groups: ' . ldap_error($this->ldapconn));
        }

        $results = ldap_get_entries($this->ldapconn, $search);

        $this->_audit('User Ldap search info: ' . print_r($results, true));

        if ($results['count'] != 0) {
            for ($i = 0; $i < $results['count']; $i++) {
                $dn = $results[$i]['dn'];

                if (strpos($dn, 'ou=tendik') !== false) {
                    return 'tendik';
                } elseif (strpos($dn, 'ou=dosen') !== false) {
                    return 'dosen';
                } elseif (strpos($dn, 'ou=admin') !== false) {
                    return 'admin';
                }
            }
        }

        return false; // No role found
    }

}