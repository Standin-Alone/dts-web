<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News_defer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->is_admin       = ($this->session->userdata('login_role') == "admin") ? true : false;
        $this->login_id       = $this->session->userdata('login_id');
        //
        $this->table          = 'news_info';
        $fields               = $this->db->list_fields($this->table);
        $this->column_order   = $this->getColumnOrder($fields);
        $this->column_search  = $this->getColumnSearch($fields);
    }

    public function getColumnOrder($fields)
    {
        $list         = [];
        $list[0]     = null;
        foreach ($fields as $field) {
            $list[] = $field;
        }
        return $list;
    }

    public function getColumnSearch($fields)
    {
        $list         = [];
        foreach ($fields as $field) {
            $list[] = $field;
        }
        return $list;
    }

    public function getRows($postData)
    {
        $this->_get_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function countFiltered($postData)
    {
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_datatables_query($postData)
    {

        $this->db->from($this->table);
        if ($this->is_admin) {
            $this->db->where(["status" => $postData['status']]);
        } else {
            $this->db->where(["status" => $postData['status'], "created_by" => $this->login_id]);
        }
        $this->db->order_by('created_at', 'DESC');

        $i = 0;
        // loop searchable columns 
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($postData['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
}
