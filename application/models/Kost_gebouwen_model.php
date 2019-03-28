<?php

class Kost_gebouwen_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('kost_gebouwen');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('kost_gebouwen');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('kost_gebouwen');
        return $query->result();
    }

    function getAllids() {
        $this->db->select('id');
        $this->db->where('id >', 0);
        $query = $this->db->get('kost_gebouwen');
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
        $query = $this->db->get('kost_gebouwen');
        return $query->result();
    }

    function insertKostGebouwen($kost_gebouwen) {
//        $kost_gebouwen->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('kost_gebouwen', $kost_gebouwen);
        return $this->db->affected_rows() > 0;
    }

    function updateKostGebouwen($kost_gebouwen) {
        $this->db->where('id', $kost_gebouwen->id);
        $this->db->update('kost_gebouwen', $kost_gebouwen);
        return $this->db->affected_rows() > 0;
    }

    function deleteKostGebouwen($kost_gebouwen) {
        $this->db->where('id', $kost_gebouwen->id);
        $this->db->delete('kost_gebouwen');
        return $this->db->affected_rows() > 0;
    }

    function kostGebouwen_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('kost_gebouwen');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('kost_gebouwen');
    }
}