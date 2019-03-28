<?php

class Machine_soort_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('machine_soort');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('machine_soort');
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
        $query = $this->db->get('machine_soort');
        return $query->result();
    }

    function insertMachineSoort($machine_soort) {
//        $machine_soort->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('machine_soort', $machine_soort);
        return $this->db->affected_rows() > 0;
    }

    function updateMachineSoort($machine_soort) {
        $this->db->where('id', $machine_soort->id);
        $this->db->update('machine_soort', $machine_soort);
        return $this->db->affected_rows() > 0;
    }

    function deleteMachineSoort($machine_soort) {
        $this->db->where('id', $machine_soort->id);
        $this->db->delete('machine_soort');
        return $this->db->affected_rows() > 0;
    }

    function machineSoort_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('machine_soort');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('machine_soort');
    }
}