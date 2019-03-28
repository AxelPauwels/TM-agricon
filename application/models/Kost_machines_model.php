<?php

class Kost_machines_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('kost_machines');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('kost_machines');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('kost_machines');
        return $query->result();
    }

    function getAllids() {
        $this->db->select('id');
        $this->db->where('id >', 0);
        $query = $this->db->get('kost_machines');
        $items = $query->result();
        $arrayMetids = array();
        foreach ($items as $item) {
            array_push($arrayMetids, $item->id);
        }
        return $arrayMetids;
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
        $query = $this->db->get('kost_machines');
        return $query->result();
    }

    function insertKostMachines($kost_machines) {
//        $kost_machines->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('kost_machines', $kost_machines);
        return $this->db->insert_id();
    }

    function updateKostMachines($kost_machines) {
        $this->db->where('id', $kost_machines->id);
        $this->db->update('kost_machines', $kost_machines);
        return $this->db->affected_rows() > 0;
    }

    function deleteKostMachines($kost_machines) {
        $this->db->where('id', $kost_machines->id);
        $this->db->delete('kost_machines');
        return $this->db->affected_rows() > 0;
    }

    function kostMachines_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('kost_machines');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('kost_machines');
    }
}