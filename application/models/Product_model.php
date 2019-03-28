<?php

class Product_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('product');
            return $query->row();
        }
    }

    function get_byFolieId($folieId) {
        $this->db->select('id,productieKostId');
        $this->db->where('folieId', $folieId);
        $query = $this->db->get('product');
        return $query->result();
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('artikelcode');
        $query = $this->db->get('product');
        return $query->result();
    }

    function getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('artikelcode');
        $query = $this->db->get('product');
        return $query->result();
    }

    function getAll_byProductieKostId($productieKostId) {
        $this->db->select('*');
        $this->db->where('productieKostId', $productieKostId);
        $query = $this->db->get('product');
        return $query->result();
    }

    function getByZoekfunctie($zoeknaam, $artikelcodeOfBeschrijving) {
        if ($artikelcodeOfBeschrijving == 'alles') {
            $this->db->select('*');
        }
        else {
            $this->db->like($artikelcodeOfBeschrijving, $zoeknaam, 'both');
        }
        $this->db->where('id >', 0);
        $this->db->order_by('artikelcode');
        $query = $this->db->get('product');
        return $query->result();
    }

    function insertProduct($product) {
//        $leverancier->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('product', $product);
        return $this->db->insert_id();
    }

    function updateProduct($product) {
        $this->db->where('id', $product->id);
        $this->db->update('product', $product);
        return $this->db->affected_rows() > 0;
    }

    function deleteProduct($product) {
        $this->db->where('id', $product->id);
        $this->db->delete('product');
        return $this->db->affected_rows() > 0;
    }

    function updateProduct_setNA_folieId($folieId) {
        $this->db->set('folieId', -1);
        $this->db->where('folieId', $folieId);
        $this->db->update('product');
        return $this->db->affected_rows() > 0;
    }

    function product_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('product');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('product');
    }

    // API functies
    function api_getByArtikelcode($artikelcode) {
        if ($artikelcode !== '') {
            $this->db->where('LOWER(artikelCode)', strtolower($artikelcode));
            $query = $this->db->get('product');
            return $query->row();
        }
        else {
            $err = new stdClass();
            $err->databaseError = "artikelCode niet gevonden";
            return $err;
        }
    }

    function api_getAll() {
        $this->db->select('artikelCode,aankoopPrijs');
        $this->db->where('id >', 0);
        $this->db->order_by('artikelcode');
        $query = $this->db->get('product');

        $producten = $query->result();
        if ($producten != null) {
            return $producten;
        }
        else {
            $err = new stdClass();
            $err->databaseError = "Geen producten gevonden";
            return $err;
        }
    }


}

?>