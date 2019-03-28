<?php

class Productiekost_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('productiekost');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
//        $this->db->order_by('artikelcode');
        $query = $this->db->get('productiekost');
        return $query->result();
    }

    function getAll_byElektriciteitKostId($elektriciteitKostId) {
        $this->db->select('*');
        $this->db->where('electriciteitKostId', $elektriciteitKostId);
        $query = $this->db->get('productiekost');
        return $query->result();
    }

    function getAll_by_personeelKostId($personeelKostId) {
        $this->db->select('*');
        $this->db->where('personeelKostId', $personeelKostId);
        $query = $this->db->get('productiekost');
        return $query->result();
    }

    function insertProductiekost($productiekost) {
//        $leverancier->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('productiekost', $productiekost);
        return $this->db->insert_id();
    }

    function updateProductiekost($productiekost) {
        $this->db->where('id', $productiekost->id);
        $this->db->update('productiekost', $productiekost);
        return $this->db->affected_rows() > 0;
    }

    function deleteProductiekost($productiekost) {
        $this->db->where('id', $productiekost->id);
        $this->db->delete('productiekost');
        return $this->db->affected_rows() > 0;
    }

    function updateProductiekost_setNA_elektriciteitKostId($elektriciteitKostId) {
        $this->db->set('electriciteitKostId', -1);
        $this->db->where('electriciteitKostId', $elektriciteitKostId);
        $this->db->update('productiekost');
        return $this->db->affected_rows() > 0;
    }

    function updateProductiekost_setNA_personeelKostId($personeelKostId) {
        $this->db->set('personeelKostId', -1);
        $this->db->where('personeelKostId', $personeelKostId);
        $this->db->update('productiekost');
        return $this->db->affected_rows() > 0;
    }


    function productiekost_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('productiekost');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('productiekost');
    }
}

?>