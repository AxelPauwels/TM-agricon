<?php

class Land_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('land');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('land');
        return $query->result();
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
        $query = $this->db->get('land');
        return $query->result();
    }

    function insertLand($land) {
//        $land->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('land', $land);
        return $this->db->affected_rows() > 0;
    }

    function updateLand($land) {
        $this->db->where('id', $land->id);
        $this->db->update('land', $land);
        return $this->db->affected_rows() > 0;
    }

    function deleteLand($land) {
        $this->db->where('id', $land->id);
        $this->db->delete('land');
        return $this->db->affected_rows() > 0;
    }

    function land_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('land');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('land');
    }

}

?>