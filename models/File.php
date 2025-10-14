<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class File
{

    private $file_name;
    private $file_type;
    private $file_date;
    private $file_size;
    private $file_error;
    private $file_tmp_name;

    private $file_abs_path;
    private $file_uri_path;

    public function init($files)
    {
        !isset($files['name']) || $this->set_file_name($files['name']);
        !isset($files['type']) || $this->set_file_type($files['type']);
        !isset($files['size']) || $this->set_file_size($files['size']);
        !isset($files['error']) || $this->set_file_error($files['error']);
        !isset($files['tmp_name']) || $this->set_file_tmp_name($files['tmp_name']);
    }

    public function set_file_name($file_name = '')
    {
        $this->file_name = $file_name;
    }

    public function get_file_name()
    {
        return $this->file_name;
    }

    public function set_file_type($file_type = '')
    {
        $this->file_type = $file_type;
    }

    public function get_file_type()
    {
        return $this->file_type;
    }

    public function set_file_date($file_date = '')
    {
        $this->file_date = $file_date;
    }

    public function get_file_date($format = '')
    {
        return $format ? date($format, $this->file_date) : $this->file_date;
    }

    public function set_file_size($file_size = 0)
    {
        $this->file_size = $file_size;
    }

    public function get_file_size($formatted = false)
    {
        if ($formatted) {
            $units = array('B', 'KB', 'MB', 'GB', 'TB');
            $this->file_size = max($this->file_size, 0);
            $pow = floor(($this->file_size ? log($this->file_size) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $this->file_size /= pow(1024, $pow);
            // $this->file_size /= (1 << (10 * $pow));
            return round($this->file_size, 2) . ' ' . $units[$pow];
        } else return $this->file_size;
    }

    public function set_file_error($file_error = 0)
    {
        $this->file_error = $file_error;
    }

    public function get_file_error()
    {
        return $this->file_error;
    }

    public function set_file_tmp_name($file_tmp_name = '')
    {
        $this->file_tmp_name = $file_tmp_name;
    }

    public function get_file_tmp_name()
    {
        return $this->file_tmp_name;
    }

    public function set_file_abs_path($file_abs_path = '')
    {
        $this->file_abs_path = $file_abs_path;
    }

    public function get_file_abs_path()
    {
        return $this->file_abs_path;
    }

    public function set_file_uri_path($file_uri_path = '')
    {
        $this->file_uri_path = $file_uri_path;
    }

    public function get_file_uri_path()
    {
        return $this->file_uri_path;
    }

}