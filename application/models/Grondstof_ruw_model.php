<?php

class Grondstof_ruw_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('grondstof_ruw');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('grondstof_ruw');
        return $query->result();
    }

    function getAll_byCategorieId($id) {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->where('grondstofCategorieId', $id);
        $this->db->order_by('naam');
        $query = $this->db->get('grondstof_ruw');
        if ($query->num_rows() > 1) {
            return $query->result();
        }
        elseif ($query->num_rows() == 1) {
            return array($query->row());
        }
        else {
            return null;
        }
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
        $query = $this->db->get('grondstof_ruw');
        return $query->result();
    }

    function insertGrondstofRuw($newGrondstofRuw) {
//        $newGrondstofRuw->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('grondstof_ruw', $newGrondstofRuw);
        return $this->db->insert_id();
    }

    function updateGrondstofRuw($updateGrondstofRuw) {
        $this->db->where('id', $updateGrondstofRuw->id);
        $this->db->update('grondstof_ruw', $updateGrondstofRuw);
        return $this->db->affected_rows() > 0;
    }

    function deleteGrondstofRuw($deleteGrondstofRuw) {
        $this->db->where('id', $deleteGrondstofRuw->id);
        $this->db->delete('grondstof_ruw');
        return $this->db->affected_rows() > 0;
    }

    function deleteGrondstofRuwById($deleteGrondstofRuwId) {
        $this->db->where('id', $deleteGrondstofRuwId);
        $this->db->delete('grondstof_ruw');
        return $this->db->affected_rows() > 0;
    }

    function getByGrondstofCategorieId($grondstofCategorieId) {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->where('grondstofCategorieId', $grondstofCategorieId);
        $this->db->order_by('naam');
        $query = $this->db->get('grondstof_ruw');

        if ($query->num_rows() > 1) {
            return $query->result();
        }
        elseif ($query->num_rows() == 1) {
            $row = $query->row();
            $result = array();
            array_push($result, $row);
            return $result;
        }
        else {
            return null;
        }
    }

    function grondstofRuw_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('grondstof_ruw');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('grondstof_ruw');
    }

}

?>