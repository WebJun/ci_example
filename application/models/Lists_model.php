<?php
/*
200314
목록 만들 때 쓰는 클래스
*/
class Lists_model extends CI_Model
{
    //테이블,뷰 가능
    private $select = null;
    private $from = null;
    private $where = null;
    private $order_key = null;
    private $order_value = null;
    private $group_by = null;
    private $limit = null;
    private $limit_size = 10; //한 페이지에 보이는 항목 수
    private $limit_offset = 0;
    private $more_page = 3; //양 옆으로 보이는 페이지 수
    private $page = 1; //현재페이지

    //결과
    private $items = array();
    private $pages = array();

    function __construct()
    {
        parent::__construct();
    }

    function set($name, $value)
    {
        $this->$name = $value;
    }

    function get($name)
    {
        return $this->$name;
    }

    //https://zetawiki.com/wiki/PHP_게시판_페이지네이션_구현 참고
    function pages()
    {
        if (isset($this->where)) {
            foreach ($this->where as $key => $val) {
                foreach ($val as $key2 => $val2) {
                    $this->db->$key($key2, $val2);
                }
            }
        }
        if (isset($this->group_by)) {
            $this->db->group_by($this->group_by);
        }
        $this->pages['tot_cnt'] = $this->db->count_all_results($this->from);
        $this->pages['c'] = intval($this->page); //현재페이지
        $this->pages['cnt'] = CEIL($this->pages['tot_cnt'] / $this->limit_size); //페이지의 총 수
        if ($this->pages['c'] < 1) $this->pages['c'] = 1; //가장 작은 페이지 : 1
        if ($this->pages['c'] > $this->pages['cnt']) $this->pages['c'] = $this->pages['cnt']; //가장 큰 페이지 : 페이지수
        $this->pages['s'] = max($this->pages['c'] - $this->more_page, 1); //블럭의 시작페이지번호
        $this->pages['e'] = min($this->pages['c'] + $this->more_page, $this->pages['cnt']); //블럭의 마지막페이지번호
        $this->pages['p'] = max($this->pages['s'] - $this->more_page - 1, 1); //현재 페이지 -1
        $this->pages['n'] = min($this->pages['e'] + $this->more_page + 1, $this->pages['cnt']); //현재 페이지 +1
        return $this->pages;
    }

    function items()
    {
        if (isset($this->select)) {
            if (is_array($this->select)) {
                $this->db->select(implode(',', $this->select));
            } else {
                $this->db->select($this->select);
            }
        }
        if (isset($this->where)) {
            foreach ($this->where as $key => $val) {
                foreach ($val as $key2 => $val2) {
                    $this->db->$key($key2, $val2);
                }
            }
        }
        if (isset($this->group_by)) {
            $this->db->group_by($this->group_by);
        }
        if (isset($this->order_key)) {
            $this->db->order_by($this->order_key . ' ' . $this->order_value);
        }
        $this->db->limit($this->limit_size, $this->limit_size * ($this->page - 1));
        $this->items = $this->db->get($this->from)->result_array();
        return $this->items;
    }
}
