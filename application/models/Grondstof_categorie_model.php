<?php

class Grondstof_categorie_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('grondstof_categorie');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('grondstof_categorie');
        return $query->result();
    }

    function getAll_zonderFractieCategorie() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->where('isFractieCategorie', false);
        $this->db->order_by('naam');
        $query = $this->db->get('grondstof_categorie');
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
        $query = $this->db->get('grondstof_categorie');
        return $query->result();
    }

    function insertCategorie($newCategorie) {
//        $newCategorie->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('grondstof_categorie', $newCategorie);
        return $this->db->affected_rows() > 0;
    }

    function updateCategorie($updateCategorie) {
        $this->db->where('id', $updateCategorie->id);
        $this->db->update('grondstof_categorie', $updateCategorie);
        return $this->db->affected_rows() > 0;
    }

    function deleteCategorie($deleteCategorie) {
        $this->db->where('id', $deleteCategorie->id);
        $this->db->delete('grondstof_categorie');
        return $this->db->affected_rows() > 0;
    }

    function grondstofCategorie_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('grondstof_categorie');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('grondstof_categorie');
    }


}

?>