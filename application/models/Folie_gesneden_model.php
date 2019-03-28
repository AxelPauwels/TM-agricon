<?php

class Folie_gesneden_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('folie_gesneden');
            return $query->row();
        }
    }

    function getByFolieRuwId($folieRuwId) {
        $this->db->where('folieRuwId', $folieRuwId);
        $query = $this->db->get('folie_gesneden');
        return $query->result();
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('folie_gesneden');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('folie_gesneden');
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
        $query = $this->db->get('folie_gesneden');
        return $query->result();
    }

    function insertFolieGesneden($folie_gesneden) {
//        $folie_gesneden->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('folie_gesneden', $folie_gesneden);
        return $this->db->affected_rows() > 0;
    }

    function updateFolieGesneden($folie_gesneden) {
        $this->db->where('id', $folie_gesneden->id);
        $this->db->update('folie_gesneden', $folie_gesneden);
        return $this->db->affected_rows() > 0;
    }

    function deleteFolieGesneden($folie_gesneden) {
        $this->db->where('id', $folie_gesneden->id);
        $this->db->delete('folie_gesneden');
        return $this->db->affected_rows() > 0;
    }
    function deleteFolieGesneden_byId($id) {
        $this->db->where('id', $id);
        $this->db->delete('folie_gesneden');
        return $this->db->affected_rows() > 0;
    }

    function folieGesneden_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('folie_gesneden');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('folie_gesneden');
    }


}

?>