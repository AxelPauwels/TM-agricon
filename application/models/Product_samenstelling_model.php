<?php

class Product_samenstelling_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('product_samenstelling');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $query = $this->db->get('product_samenstelling');
        return $query->result();
    }

    function getByProductId($productId) {
        $this->db->select('*');
        $this->db->where('productId', $productId);
        $query = $this->db->get('product_samenstelling');
        return $query->result();
    }

    function get_byGrondstofAfgewerktId($grondstofAfgewerktId) {
        $this->db->select('*');
        $this->db->where('grondstofAfgewerktId', $grondstofAfgewerktId);
        $query = $this->db->get('product_samenstelling');
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
        $query = $this->db->get('product_samenstelling');
        return $query->result();
    }

    function insertProductSamenstelling($productSamenstelling) {
//        $kost_gebouwen->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('product_samenstelling', $productSamenstelling);
        return $this->db->affected_rows() > 0;
    }

    function updateProductSamenstelling($productSamenstelling) {
        $this->db->where('id', $productSamenstelling->id);
        $this->db->update('product_samenstelling', $productSamenstelling);
        return $this->db->affected_rows() > 0;
    }

    function deleteProductSamenstelling($productSamenstelling) {
        $this->db->where('id', $productSamenstelling->id);
        $this->db->delete('product_samenstelling');
        return $this->db->affected_rows() > 0;
    }

    function deleteProductSamenstelling_byId($productSamenstellingId) {
        $this->db->where('id', $productSamenstellingId);
        $this->db->delete('product_samenstelling');
        return $this->db->affected_rows() > 0;
    }

    function deleteAll_byProductId($productId) {
        $this->db->where('productId', $productId);
        $this->db->delete('product_samenstelling');
    }

    function updateProductSamenstelling_setNA_grondstofAfgewerktId($productSamenstellingId) {
        $this->db->set('grondstofAfgewerktId', -1);
        $this->db->where('id', $productSamenstellingId);
        $this->db->update('product_samenstelling');
        return $this->db->affected_rows() > 0;
    }

    function productSamenstelling_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('product_samenstelling');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('product_samenstelling');
    }
}