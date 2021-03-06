<?php
/**
 * Copyright (c) 2020.
 * All this code was written by Abolfazl Alizadeh.
 */

class MediaCollectionControl extends TableControlHelper
{
    public function __construct()
    {
        parent::__construct(DatabaseControl::get_media_control());
    }

    /**
     * @param string $title
     * @return int
     * @throws DatabaseException
     */
    public function create_new_collection($title)
    {
        $data = ['name' => $title];
        $insert = $this->tableControl->insert_if_not_exist($data, $data);
        $this->check_query_run_result();
        if ($insert == -1) {
            return $this->select_rows_by_condition(['name' => $title])[0]['id'];
        }
        return $insert;
    }

    /**
     * @param $title
     * @return array
     * @throws DatabaseException
     */
    public function get_collection_by_title($title)
    {
        $data = ['name' => $title];
        $select = $this->select_rows_by_condition($data);
        $this->check_query_run_result();
        if (count($select) == 0)
            return array();
        return $select[0];
    }

    /**
     * @param $id
     * @return array
     * @throws DatabaseException
     */
    public function get_collection_by_id($id)
    {
        $data = ['id' => $id];
        $select = $this->select_rows_by_condition($data);
        $this->check_query_run_result();
        if (count($select) == 0)
            return array();
        return $select[0];
    }

    /**
     * @param $array
     * @return mixed|void
     * @throws DatabaseException
     */
    public function fix_format($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            $array[$i]['files'] = (new MediaTableControl())->select_rows_by_condition(['collectionId' => $array[$i]['id']]);
        }
        return $array;
    }
}