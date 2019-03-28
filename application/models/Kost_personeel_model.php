<?php

class Kost_personeel_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('kost_personeel');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('kost_personeel');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('kost_personeel');
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
        $query = $this->db->get('kost_personeel');
        return $query->result();
    }

    function insertKostPersoneel($kost_personeel) {
//        $kost_personeel->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('kost_personeel', $kost_personeel);
        return $this->db->affected_rows() > 0;
    }

    function updateKostPersoneel($kost_personeel) {
        $this->db->where('id', $kost_personeel->id);
        $this->db->update('kost_personeel', $kost_personeel);
        return $this->db->affected_rows() > 0;
    }

    function deleteKostPersoneel($kost_personeel) {
        $this->db->where('id', $kost_personeel->id);
        $this->db->delete('kost_personeel');
        return $this->db->affected_rows() > 0;
    }
    function deleteKostPersoneel_byId($kost_personeelId) {
        $this->db->where('id', $kost_personeelId);
        $this->db->delete('kost_personeel');
        return $this->db->affected_rows() > 0;
    }

    function kostPersoneel_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('kost_personeel');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('kost_personeel');
    }
}