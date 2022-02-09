<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('News_model', 'news');
        //
        $this->ip_address     = $_SERVER['REMOTE_ADDR'];
        $this->datetime     = date('Y-m-d H:i:s');
        $this->login_id     = $this->session->userdata('login_id');
        $this->login_name     = $this->session->userdata('login_name');
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $data                     = [];
        $data['content_title']     = 'News - List';
        $data['status_list']    = $this->status->get_all(["status" => "1"]);
        $this->load->view('list', $data);
    }

    public function news_datatable()
    {
        $arrayList = [];
        $result     = $this->news_defer->getRows($this->input->get());
        $i             = $this->input->get('start');
        foreach ($result as $row) {
            $action = '
			<a href="' . base_url('news/edit?id=' . $row->id) . '" class="btn btn-sm btn-primary">
              <i class="fe-edit"></i> Edit</a>
			<button name="deleteButton" data-id="' . $row->id . '" class="btn btn-sm btn-danger">
              <i class="fe-trash"></i> Delete</button>
			';
            $arrayList[] = [
                ++$i,
                nice_date($row->created_at, 'd-m-Y H:i:s'),
                $row->title,
                $row->description,
                $action
            ];
        }
        $output = array(
            "draw"                 => $this->input->get('draw'),
            "recordsTotal"         => $this->news_defer->countAll(),
            "recordsFiltered"    => $this->news_defer->countFiltered($this->input->get()),
            "data"                 => $arrayList,
        );

        echo json_encode($output);
    }

    public function delete()
    {
        $id         = $this->input->post('id');
        $where         = ['id' => $id];
        $result = $this->news->delete($where);
        if ($result) {
            echo "deleted";
        }
    }
}
