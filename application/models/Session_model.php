<?php
class Session_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * CREATE TABLE IF NOT EXISTS `ci_sessions` (
     *     `id` varchar(128) NOT NULL,
     *     `ip_address` varchar(45) NOT NULL,
     *     `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
     *     `data` blob NOT NULL,
     *     KEY `ci_sessions_timestamp` (`timestamp`)
     * );
     */
    public function create()
    {
        $this->load->dbforge();
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
            ],
            'timestamp' => [
                'type' =>'INT',
                'unsigned' => TRUE,
                'default' => 0,
            ],
            'data' => [
                'type' => 'blob',
            ],
        ];
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('timestamp');
        $this->dbforge->create_table('ci_sessions');
    }

    public function isExists()
    {
        $result = false;
        $tables = $this->db->list_tables();
        foreach ($tables as $table)
        {
            if ($table === 'ci_sessions') {
                $result = true;
                break;
            }
        }
        return $result;
    }

}