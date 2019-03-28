<?php

class Leverancier_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('leverancier');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('leverancier');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('leverancier');
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
        $query = $this->db->get('leverancier');
        return $query->result();
    }

    function insertLeverancier($leverancier) {
//        $leverancier->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('leverancier', $leverancier);
        return $this->db->affected_rows() > 0;
    }

    function updateLeverancier($leverancier) {
        $this->db->where('id', $leverancier->id);
        $this->db->update('leverancier', $leverancier);
        return $this->db->affected_rows() > 0;
    }

    function deleteLeverancier($leverancier) {
        $this->db->where('id', $leverancier->id);
        $this->db->delete('leverancier');
        return $this->db->affected_rows() > 0;
    }

    function updateLeverancier_setNA_stadGemeenteId($stadGemeenteId) {
        $this->db->set('stadGemeenteId', -1);
        $this->db->where('stadGemeenteId', $stadGemeenteId);
        $this->db->update('leverancier');
        return $this->db->affected_rows() > 0;
    }

    function updateLeverancier_setNA_leverancierSoortId($leverancierSoortId) {
        $this->db->set('leverancierSoortId', -1);
        $this->db->where('leverancierSoortId', $leverancierSoortId);
        $this->db->update('leverancier');
        return $this->db->affected_rows() > 0;
    }

    function leverancier_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('leverancier');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('leverancier');
    }

}

?>