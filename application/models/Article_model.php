<?php
class Article_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * CREATE TABLE `T_ARTICLE` (
     *     `seq` INT(11) NOT NULL AUTO_INCREMENT COMMENT '인덱스',
     *     `title` VARCHAR(50) NOT NULL COMMENT '제목',
     *     `content` text NOT NULL COMMENT '내용',
     *     `writer` VARCHAR(50) NOT NULL DEFAULT COMMENT '작성자',
     *     `date` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '생성날짜',
     *     `created` DATETIME NOT NULL COMMENT '생성시각',
     *     PRIMARY KEY (`seq`)
     * );
     */
    public function create()
    {
        $this->load->dbforge();
        $fields = [
            'seq' => [
                'type' => 'INT',
                'auto_increment' => TRUE,
                'comment' => '인덱스',
            ],
            'title' => [
                'type' =>'VARCHAR',
                'constraint' => 50,
                'comment' => '제목',
            ],
            'content' => [
                'type' =>'text',
                'comment' => '내용',
            ],
            'writer' => [
                'type' =>'VARCHAR',
                'constraint' => 50,
                'comment' => '작성자',
            ],
            'updated' => [
                'type' =>'VARCHAR',
                'constraint' => 50,
                'comment' => '최종수정시각',
            ],
            'date' => [
                'type' =>'VARCHAR',
                'constraint' => 10,
                'comment' => '생성날짜',
            ],
            'created' => [
                'type' =>'VARCHAR',
                'constraint' => 50,
                'comment' => '생성시각',
            ],
        ];
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('seq', true);
        $this->dbforge->create_table('T_ARTICLE');
    }

    public function isExists()
    {
        $result = false;
        $tables = $this->db->list_tables();
        foreach ($tables as $table)
        {
            if ($table === 'T_ARTICLE') {
                $result = true;
                break;
            }
        }
        return $result;
    }


}