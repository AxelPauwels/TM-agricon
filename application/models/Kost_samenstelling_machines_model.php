<?php

class Kost_samenstelling_machines_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('kost_machines_samenstelling');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $query = $this->db->get('kost_machines_samenstelling');
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
        $query = $this->db->get('kost_machines_samenstelling');
        return $query->result();
    }

    function getByProductieKostId($productieKostId) {
        $this->db->where('productieKostId', $productieKostId);
        $query = $this->db->get('kost_machines_samenstelling');
        return $query->result();
    }

    function insertKostMachines($kost_machines) {
//        $kost_gebouwen->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('kost_machines_samenstelling', $kost_machines);
        return $this->db->affected_rows() > 0;
    }

    function updateKostMachines($kost_machines) {
        $this->db->where('id', $kost_machines->id);
        $this->db->update('kost_machines_samenstelling', $kost_machines);
        return $this->db->affected_rows() > 0;
    }

    function deleteKostMachines($kost_machines) {
        $this->db->where('id', $kost_machines->id);
        $this->db->delete('kost_machines_samenstelling');
        return $this->db->affected_rows() > 0;
    }

    function deleteAll_byProductieKostId($productieKostId) {
        $this->db->where('productieKostId', $productieKostId);
        $this->db->delete('kost_machines_samenstelling');
    }

    function kostMachines_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('kost_machines_samenstelling');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('kost_machines_samenstelling');
    }

}