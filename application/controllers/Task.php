<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_task', 'task');
        $this->load->helper('url', 'file');
        $this->load->library('upload');
    }

    // View Controller
    public function index() {
        $sortOption = $this->input->post('status');
        $data['tasks'] = $this->task->get_all($sortOption);
        $data['selected'] = $sortOption;

        $this->load->view('header');
        $this->load->view('task_list', $data);
        $this->load->view('footer');
    }

    public function detail($id) {
        $data['task'] = $this->task->get($id);
        $this->load->view('header');
        $this->load->view('task_detail', $data);
        $this->load->view('footer');
    }

    public function create() {
        $this->load->view('header');
        $this->load->view('task_form');
        $this->load->view('footer');
    }

    // Model Controller
    public function store() {
        $data = $this->input->post();
        $this->task->insert($data);
        redirect('');
    }

    public function update($id) {
        $data = $this->input->post();
        $this->task->update($id, $data);
        redirect('');
    }

    public function delete($id) {
        $task = $this->task->get($id);
        if ($task['image_path'] && file_exists($task['image_path'])) {
            unlink($task['image_path']);
        }

        $this->task->delete($id);
        redirect('');
    }

    // Task Detail Controllers
    public function update_info($id) {
        $data = $this->input->post();

        $this->db->set([
            'title' => $data['title'],
            'status' => $data['status'],
            'deadline' => $data['deadline']
        ]);

        $this->db->where('id', $id);
        $this->db->update('tasks');

        redirect('detail/' . $id);
    }


    public function update_description($id) {
        $data = $this->input->post();
        $this->task->update($id, $data);
        redirect('detail/'.$id);
    }

    public function upload_image($id) {
        $task = $this->task->get($id);
        if (!$task) {
            redirect('');
            return;
        }
        
        $old_image = $task['image_path'] ?? null;

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        
        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload('task_image')) {

            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
        } else {
            $upload_data = $this->upload->data();
            $image_path = 'uploads/' . $upload_data['file_name'];

            $this->task->update($id, ['image_path' => $image_path]);

            if ($old_image && file_exists('./' . $old_image)) {
                unlink('./' . $old_image);
            }

            $this->task->update($id, ['image_path' => $image_path]);
            $this->session->set_flashdata('success', 'Image uploaded successfully');
        }
        
        redirect('task/detail/' . $id);
    }

    public function delete_image($id) {
        $task = $this->task->get($id);
        if (!$task) {
            redirect('');
            return;
        }

        if ($task['image_path'] && file_exists($task['image_path'])) {
            unlink($task['image_path']);
        }

        $this->task->update($id, ['image_path' => null]);
        
        $this->session->set_flashdata('success', 'Image deleted successfully');
        redirect('task/detail/' . $id);
    }
}