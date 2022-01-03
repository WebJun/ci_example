<?php
class MY_Model extends CI_Model
{
    /*
    CRUD
    create -> insert
    read -> get,gets,cnt
    update -> update
    delete -> delete
    */
    public function __construct()
    {
        parent::__construct();
    }
    private function select($table, $data = [])
    {
        if (isset($data['select'])) {
            $fields = $this->db->list_fields($table);
            if (!is_array($data['select'])) {
                $data['select'] = explode(',', $data['select']);
            }

            $data['select'] = array_filter($fields, function ($v) use ($data) {
                return in_array($v, $data['select']);
            });
            $this->db->select(implode(',', $data['select']));
        }
        //mall_seq as seq 이런 경우
        if (isset($data['select2'])) {
            $this->db->select($data['select2']);
        }
        if (isset($data['select_max'])) $this->db->select_max($data['select_max']);
        if (isset($data['select_min'])) $this->db->select_min($data['select_min']);
        if (isset($data['distinct'])) $this->db->distinct($data['distinct']);
        if (isset($data['group_by'])) $this->db->group_by($data['group_by']);
        if (isset($data['order_by'])) $this->db->order_by($data['order_by']);
        if (isset($data['limit_size'])) {
            if (isset($data['limit_offset'])) {
                $this->db->limit($data['limit_size'], $data['limit_offset']);
            } else {
                $this->db->limit($data['limit_size'], 0);
            }
        }
    }
    private function where($data = [])
    {
        if (isset($data['where'])) $this->db->where($data['where']);
        if (isset($data['or_where'])) $this->db->or_where($data['or_where']);
        if (isset($data['where_in'])) {
            foreach ($data['where_in'] as $key => $val) {
                $this->db->where_in($key, $val);
            }
        }
        if (isset($data['or_where_in'])) {
            foreach ($data['or_where_in'] as $key => $val) {
                $this->db->or_where_in($key, $val);
            }
        }
        if (isset($data['where_not_in'])) {
            foreach ($data['where_not_in'] as $key => $val) {
                $this->db->where_not_in($key, $val);
            }
        }
        if (isset($data['or_where_not_in'])) {
            foreach ($data['or_where_not_in'] as $key => $val) {
                $this->db->or_where_not_in($key, $val);
            }
        }
        if (isset($data['like'])) $this->db->like($data['like']);
        if (isset($data['like_before'])) {
            foreach ($data['like_before'] as $key => $val) {
                $this->db->like($key, $val, 'before');
            }
        }
        if (isset($data['like_after'])) {
            foreach ($data['like_after'] as $key => $val) {
                $this->db->like($key, $val, 'after');
            }
        }
        if (isset($data['like_both'])) {
            foreach ($data['like_both'] as $key => $val) {
                $this->db->like($key, $val, 'both');
            }
        }
        if (isset($data['or_like'])) $this->db->or_like($data['or_like']);
        if (isset($data['not_like'])) $this->db->not_like($data['not_like']);
        if (isset($data['or_not_like'])) $this->db->or_not_like($data['or_not_like']);
    }
    //세번째 인자 $primary_key에는 필드명이 옴
    //그것을 키로 하는 배열 형태로 리턴함
    function gets($table, $data = [], $primary_key = false)
    {
        $this->select($table, $data);
        $this->where($data);
        if ($primary_key === false) {
            $data2 = $this->db->get($table)->result_array();
        } else {
            $temp = $this->db->get($table)->result_array();
            $data2 = [];
            foreach ($temp as $entry) {
                $data2[$entry[$primary_key]] = $entry;
            }
        }
        return $data2;
    }
    function get($table, $data = [])
    {
        $this->select($data);
        $this->where($data);
        return $this->db->get($table)->row_array();
    }
    function cnt($table, $data = [])
    {
        $this->select($data);
        $this->where($data);
        return $this->db->count_all_results($table);
    }
    //세번째 인자 $result가 true이면 insert_id를 false이면 영향받은 레코드 수를 리턴한다.
    //보통 기본키가 auto_increment일때 true를 쓰고 아니면 false를 쓴다.
    function insert($table, $data = [], $result = true)
    {
        $fields = $this->db->list_fields($table);
        $data2 = []; //테이블 필드에 있는 애들만 넣어줌.
        foreach ($fields as $entry) {
            if (isset($data[$entry])) {
                $data2[$entry] = $data[$entry];
            }
        }
        $this->db->insert($table, $data2);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return $this->db->affected_rows();
        }
    }
    function delete($table, $data = [])
    {
        $this->where($data);
        $this->db->delete($table);
        return $this->db->affected_rows(); //영향받은 레코드 수

    }
    function update($table, $data = [])
    {
        $this->where($data);
        $this->db->update($table, $data['set']);
        return $this->db->affected_rows(); //영향받은 레코드 수

    }
    function update_bak200513($table, $data = [], $result = true)
    {
        $fields = $this->db->list_fields($table);
        $data2 = [];
        foreach ($fields as $entry) {
            if (isset($data['set'][$entry])) {
                $data2[$entry] = $data['set'][$entry];
            }
        }
        $this->select($data);
        $this->db->update($table, $data2);
        return $this->db->affected_rows(); //영향받은 레코드 수

    }
    function query($sql)
    {
        $result = $this->db->query($sql);
        return $result;
    }
    /*
     * 테이블 비우기
    */
    function truncate($table)
    {
        return $this->db->truncate($table);
    }
    /**
     * 2020.09.22
     * 한번에 많이 insert하는 함수
     *
     * @param string 테이블
     * @param array 키가 필드명으로 된 연관배열
     * @param array 안넣을 필드명 배열
     * @param int 한번에 넣을 수
     * @return
     */
    function many_insert($table, $value, $unsets = [], $once = 1000)
    {
        $table_fields = $this->db->list_fields($table);
        $value_fields = array_keys($value[0]);
        $fields = array_intersect($table_fields, $value_fields);
        foreach ($unsets as $entry) {
            $index = array_search($entry, $fields);
            unset($fields[$index]);
        }
        for ($i = 0; $i < count($value); $i = $i + $once) {
            $data = array_slice($value, $i, $once);
            $bbb = [];
            $query = '';
            $query .= 'insert into ' . $table . '(' . join(',', $fields) . ') values';
            foreach ($data as $key => $val) {
                $aaa = [];
                foreach ($fields as $key2 => $val2) {
                    if (isset($data[$key][$val2])) {
                        $aaa[] = "'" . addslashes($data[$key][$val2]) . "'";
                    } else {
                        $aaa[] = "''";
                    }
                }
                $bbb[] = '(' . join(',', $aaa) . ')';
            }
            $query .= join(',', $bbb) . ';';
            $this->main_model->query($query);
        }
    }
}
