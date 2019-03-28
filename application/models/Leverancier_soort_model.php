<?php

class Leverancier_soort_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('leverancier_soort');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('leverancier_soort');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('leverancier_soort');
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
        $query = $this->db->get('leverancier_soort');
        return $query->result();
    }

    function insertLeverancierSoort($leverancierSoort) {
//        $leverancierSoort->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('leverancier_soort', $leverancierSoort);
        return $this->db->affected_rows() > 0;
    }

    function updateLeverancierSoort($leverancierSoort) {
        $this->db->where('id', $leverancierSoort->id);
        $this->db->update('leverancier_soort', $leverancierSoort);
        return $this->db->affected_rows() > 0;
    }

    function deleteLeverancierSoort($leverancierSoort) {
        $this->db->where('id', $leverancierSoort->id);
        $this->db->delete('leverancier_soort');
        return $this->db->affected_rows() > 0;
    }

    function leverancierSoort_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('leverancier_soort');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('leverancier_soort');
    }


}

?>