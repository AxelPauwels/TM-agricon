<?php

class Kost_elektriciteit_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('kost_elektriciteit');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('kost_elektriciteit');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('kost_elektriciteit');
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
        $query = $this->db->get('kost_elektriciteit');
        return $query->result();
    }

    function insertKostElektriciteit($kost_elektriciteit) {
//        $kost_elektriciteit->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('kost_elektriciteit', $kost_elektriciteit);
        return $this->db->affected_rows() > 0;
    }

    function updateKostElektriciteit($kost_elektriciteit) {
        $this->db->where('id', $kost_elektriciteit->id);
        $this->db->update('kost_elektriciteit', $kost_elektriciteit);
        return $this->db->affected_rows() > 0;
    }

    function deleteKostElektriciteit($kost_elektriciteit) {
        $this->db->where('id', $kost_elektriciteit->id);
        $this->db->delete('kost_elektriciteit');
        return $this->db->affected_rows() > 0;
    }

    function deleteKostElektriciteit_byId($kost_elektriciteitId) {
        $this->db->where('id', $kost_elektriciteitId);
        $this->db->delete('kost_elektriciteit');
        return $this->db->affected_rows() > 0;
    }

    function kostElektriciteit_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('kost_elektriciteit');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('kost_elektriciteit');
    }
}