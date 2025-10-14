<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MPengaturan implements Template
{

    private $pengaturan_key;
    private $pengaturan_value;

    public function _id()
    {
        return $this->pengaturan_key;
    }

    public function _init($request)
    {

    }

    public function _toArray()
    {
        
    }

    /**
     * @return mixed
     */
    public function getPengaturanKey()
    {
        return $this->pengaturan_key;
    }

    /**
     * @param mixed $pengaturan_key
     * @return MPengaturan
     */
    public function setPengaturanKey($pengaturan_key)
    {
        $this->pengaturan_key = $pengaturan_key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengaturanValue()
    {
        return $this->pengaturan_value;
    }

    /**
     * @param mixed $pengaturan_value
     * @return MPengaturan
     */
    public function setPengaturanValue($pengaturan_value)
    {
        $this->pengaturan_value = $pengaturan_value;
        return $this;
    }
}