<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            // geef user-object met opgegeven $id
            $this->db->where('id', $id);
            $query = $this->db->get('user');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('id, naam');
        $this->db->where('id >', 0);
        $query = $this->db->get('user');
        return $query->result();
    }

    function getUser($naam, $wachtwoord) {
        // geef user-object met $email en $password EN geactiveerd = 1
        $this->db->where('naam', $naam);
        $this->db->where('wachtwoord', $wachtwoord);
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        else {
            return null;
        }
    }

    function getUser_byId($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->row();
    }

    function getUserNaam_byId($id) {
        $this->db->select('naam');
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->row()->naam;
    }

    function getByZoekfunctie($zoeknaam) {
        if ($zoeknaam == '') {
            $this->db->select('*');
        }
        else {
            $this->db->like('naam', $zoeknaam, 'both');
        }
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('user');
        return $query->result();
    }

    function checkIfUsernameExists($naam) {
        $this->db->where('naam', $naam);
        $query = $this->db->get('user');
        if($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

    function insertUser($user) {
        $this->db->insert('user', $user);
        return $this->db->insert_id();
    }

    function updateUser($user) {
        $this->db->where('id', $user->id);
        $this->db->update('user', $user);
        return $this->db->affected_rows() > 0;
    }

    function deleteUser($user) {
        $this->db->where('id', $user->id);
        $this->db->delete('user');
        return $this->db->affected_rows() > 0;
    }


}

?>