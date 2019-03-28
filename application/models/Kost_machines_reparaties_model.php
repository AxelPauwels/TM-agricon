<?php

class Kost_machines_reparaties_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('kost_machines_reparaties');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('kost_machines_reparaties');
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
        $query = $this->db->get('kost_machines_reparaties');
        return $query->result();
    }

    function get_byKostMachineId($id) {
        $this->db->where('kostMachinesId', $id);
        $query = $this->db->get('kost_machines_reparaties');
        return $query->result();
    }

    function getTotaalKost_byKostMachineId($id) {
        $this->db->select_sum('reparatieKostPerReparatie');
        $this->db->where('kostMachinesId', $id);
        $query = $this->db->get('kost_machines_reparaties');
        return $query->row()->reparatieKostPerReparatie;
    }

    function insertKostMachinesReparatie($kost_machines) {
//        $kost_machines->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('kost_machines_reparaties', $kost_machines);
        return $this->db->affected_rows() > 0;
    }

    function updateKostMachinesReparatie($kost_machines) {
        $this->db->where('id', $kost_machines->id);
        $this->db->update('kost_machines_reparaties', $kost_machines);
        return $this->db->affected_rows() > 0;
    }

    function deleteKostMachinesReparatie($kost_machines) {
        $this->db->where('id', $kost_machines->id);
        $this->db->delete('kost_machines_reparaties');
        return $this->db->affected_rows() > 0;
    }

    function kostMachinesReparatie_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('kost_machines_reparaties');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('kost_machines_reparaties');
    }


}