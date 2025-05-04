<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_task extends CI_Model {

    public function get_all($sortOption = null) {
        switch ($sortOption) {
            case 1:
                $this->db->order_by('deadline', 'DESC');
                break;
            case 2:
                $this->db->order_by('deadline', 'ASC');
                break;
            case 3:
                $this->db->order_by('created_at', 'DESC');
                break;
            case 4:
                $this->db->order_by('created_at', 'ASC');
                break;
            case 5:
                $this->db->order_by('status', 'ASC');
                break;
            default:
                $this->db->order_by('created_at', 'DESC');
                break;
        }
        return $this->db->get('tasks')->result_array();
    }

    public function get($id) {
        return $this->db->get_where('tasks', ['id' => $id])->row_array();
    }

    public function insert($data) {
        return $this->db->insert('tasks', $data);
    }

    public function update($id, $data) {
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('tasks');
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('tasks');
    }
}
