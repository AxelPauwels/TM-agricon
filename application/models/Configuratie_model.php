<?php

class Configuratie_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // EENHEID
    function eenheid_get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('config_eenheid');
            return $query->row();
        }
    }

    function eenheid_getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('config_eenheid');
        return $query->result();
    }

    function eenheid_getByZoekfunctie($zoeknaam) {
        if ($zoeknaam == '') {
            $this->db->select('*');
        }
        else {
            $this->db->like('naam', $zoeknaam, 'both');
        }
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('config_eenheid');
        return $query->result();
    }

    function insertEenheid($newEenheid) {
//        $newEenheid->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('config_eenheid', $newEenheid);
        return $this->db->affected_rows() > 0;
    }

    function updateEenheid($updateEenheid) {
        $this->db->where('id', $updateEenheid->id);
        $this->db->update('config_eenheid', $updateEenheid);
        return $this->db->affected_rows() > 0;
    }

    function deleteEenheid($deleteEenheid) {
        $this->db->where('id', $deleteEenheid->id);
        $this->db->delete('config_eenheid');
        return $this->db->affected_rows() > 0;
    }

    function eenheid_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('config_eenheid');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('config_eenheid');
    }


    // OMZET
    function omzet_get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('config_omzet');
            return $query->row();
        }
    }

    function omzet_getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('config_omzet');
        return $query->result();
    }

    function omzet_getAll_metNA() {
        $this->db->select('*');
        $this->db->order_by('naam');
        $query = $this->db->get('config_omzet');
        return $query->result();
    }

    function omzet_getByZoekfunctie($zoeknaam) {
        if ($zoeknaam == '') {
            $this->db->select('*');
        }
        else {
            $this->db->like('naam', $zoeknaam, 'both');
        }
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('config_omzet');
        return $query->result();
    }

    function insertOmzet($omzet) {
//        $newEenheid->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('config_omzet', $omzet);
        return $this->db->affected_rows() > 0;
    }

    function updateOmzet($omzet) {
        $this->db->where('id', $omzet->id);
        $this->db->update('config_omzet', $omzet);
        return $this->db->affected_rows() > 0;
    }

    function deleteOmzet($omzet) {
        $this->db->where('id', $omzet->id);
        $this->db->delete('config_omzet');
        return $this->db->affected_rows() > 0;
    }

    function omzet_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('config_omzet');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('config_omzet');
    }

    // VERPAKKINGSKOST
    function verpakkingskost_get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('config_verpakkingskost');
            return $query->row();
        }
    }

    function verpakkingskost_getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('verpakkingskost');
        $query = $this->db->get('config_verpakkingskost');
        return $query->result();
    }

    function verpakkingskost_getByZoekfunctie($zoeknaam) {
        if ($zoeknaam == '') {
            $this->db->select('*');
        }
        else {
            $this->db->like('verpakkingskost', $zoeknaam, 'both');
        }
        $this->db->where('id >', 0);
        $this->db->order_by('verpakkingskost');
        $query = $this->db->get('config_verpakkingskost');
        return $query->result();
    }

    function insertVerpakkingskost($verpakkingskost) {
//        $newEenheid->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('config_verpakkingskost', $verpakkingskost);
        return $this->db->affected_rows() > 0;
    }

    function updateVerpakkingskost($verpakkingskost) {
        $this->db->where('id', $verpakkingskost->id);
        $this->db->update('config_verpakkingskost', $verpakkingskost);
        return $this->db->affected_rows() > 0;
    }

    function deleteVerpakkingskost($verpakkingskost) {
        $this->db->where('id', $verpakkingskost->id);
        $this->db->delete('config_verpakkingskost');
        return $this->db->affected_rows() > 0;
    }

    function verpakkingskost_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('config_verpakkingskost');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('config_verpakkingskost');
    }

}

?>