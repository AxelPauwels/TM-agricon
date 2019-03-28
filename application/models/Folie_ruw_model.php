<?php

class Folie_ruw_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('folie_ruw');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('folie_ruw');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('folie_ruw');
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
        $query = $this->db->get('folie_ruw');
        return $query->result();
    }

    function insertFolieRuw($folieRuw) {
//        $folieRuw->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('folie_ruw', $folieRuw);
        return $this->db->affected_rows() > 0;
    }

    function updateFolieRuw($folieRuw) {
        $this->db->where('id', $folieRuw->id);
        $this->db->update('folie_ruw', $folieRuw);
        return $this->db->affected_rows() > 0;
    }

    function deleteFolieRuw($folieRuw) {
        $this->db->where('id', $folieRuw->id);
        $this->db->delete('folie_ruw');
        return $this->db->affected_rows() > 0;
    }

    function updateFolieRuw_setNA_leverancierId($leverancierId) {
        $this->db->set('leverancierId', -1);
        $this->db->where('leverancierId', $leverancierId);
        $this->db->update('folie_ruw');
        return $this->db->affected_rows() > 0;
    }

    function folieRuw_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('folie_ruw');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('folie_ruw');
    }


}

?>