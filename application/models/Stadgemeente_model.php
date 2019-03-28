<?php

class Stadgemeente_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('stadgemeente');
            return $query->row();
        }
    }

    function getByLandid($landId) {
        $this->db->select('id');
        $this->db->where('landId', $landId);
        $query = $this->db->get('stadgemeente');
        return $query->result();
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('stadgemeente');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('stadgemeente');
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
        $query = $this->db->get('stadgemeente');
        return $query->result();
    }

    function insertStadGemeente($stadgemeente) {
//        $stadgemeente->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('stadgemeente', $stadgemeente);
        return $this->db->affected_rows() > 0;
    }

    function updateStadGemeente($stadgemeente) {
        $this->db->where('id', $stadgemeente->id);
        $this->db->update('stadgemeente', $stadgemeente);
        return $this->db->affected_rows() > 0;
    }

    function deleteStadGemeente($stadgemeente) {
        $this->db->where('id', $stadgemeente->id);
        $this->db->delete('stadgemeente');
        return $this->db->affected_rows() > 0;
    }

    function deleteStadGemeente_byId($id) {
        $this->db->where('id', $id);
        $this->db->delete('stadgemeente');
        return $this->db->affected_rows() > 0;
    }

    function stadGemeente_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('stadgemeente');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('stadgemeente');
    }

}

?>