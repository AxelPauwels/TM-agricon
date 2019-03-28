<?php

class Grondstof_afgewerkt_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        if ($id != 0 && $id != "0") {
            $this->db->where('id', $id);
            $query = $this->db->get('grondstof_afgewerkt');
            return $query->row();
        }
    }

    function getAll() {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->order_by('naam');
        $query = $this->db->get('grondstof_afgewerkt');
        return $query->result();
    }

    function getAll_byGrondstofRuwId($id) {
        $this->db->select('*');
        $this->db->where('id >', 0);
        $this->db->where('grondstofRuwId', $id);
        $this->db->order_by('naam');
        $query = $this->db->get('grondstof_afgewerkt');
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

    function insertGrondstofAfgewerkt($newGrondstofAfgewerkt) {
//        $newGrondstofAfgewerkt->toegevoegdOp = date('Y-m-d H:i:s', time());
        $this->db->insert('grondstof_afgewerkt', $newGrondstofAfgewerkt);
        return $this->db->affected_rows() > 0;
    }

    function updateGrondstofAfgewerkt($updateGrondstofAfgewerkt) {
        $this->db->where('id', $updateGrondstofAfgewerkt->id);
        $this->db->update('grondstof_afgewerkt', $updateGrondstofAfgewerkt);
        return $this->db->affected_rows() > 0;
    }

    function deleteGrondstofAfgewerkt($deleteGrondstofAfgewerkt) {
        $this->db->where('id', $deleteGrondstofAfgewerkt->id);
        $this->db->delete('grondstof_afgewerkt');
        return $this->db->affected_rows() > 0;
    }

    function getByGrondstofRuwIds($grondstoffenRuwIds) {
        $this->db->select('*');
        $this->db->where('id >', 0);

        $first = true;
        foreach ($grondstoffenRuwIds as $grondstofRuwId) {
            if ($first) {
                $first = false;
                $this->db->where('grondstofRuwId', $grondstofRuwId);
            }
            else {
                $this->db->or_where('grondstofRuwId', $grondstofRuwId);
            }
        }
        $this->db->order_by('naam');
        $query = $this->db->get('grondstof_afgewerkt');

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

    function grondstofAfgewerkt_setAllNA_toegevoegd_of_gewijzigd($userId) {
        $this->db->where('gewijzigdDoor', $userId);
        $this->db->set('gewijzigdDoor', -1);
        $this->db->update('grondstof_afgewerkt');

        $this->db->flush_cache();
        $this->db->where('toegevoegdDoor', $userId);
        $this->db->set('toegevoegdDoor', -1);
        $this->db->update('grondstof_afgewerkt');
    }
}

?>