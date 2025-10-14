<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MTempat implements Template
{
    private $tempat_id;
    private $tempat_waktu;
    private $tempat_waktu_update;
    private $tempat_nama;
    private $tempat_alamat;
    private $tempat_telpon;
    private $tempat_pic;
    private $tempat_pic_jabatan;
    private $tempat_pic_hp;
    private $tempat_keterangan;
    private $tempat_status;

    public function _id()
    {
        return $this->tempat_id;
    }

    public function _init($request)
    {
        foreach ($request as $field => $value)
            !array_key_exists($field, $this->_toArray())
            || $this->{'set' . Helpers::_camel_case($field, '_', '')}($value);

        return $this;
    }

    public function _toArray($type = Helpers::type_attribute_all, $exclude = array())
    {
        return Helpers::_to_array(get_object_vars($this), $type, $exclude);
    }

    public function _empty()
    {
        return Helpers::_empty($this->tempat_id);
    }

    /**
     * @return mixed
     */
    public function getTempatId()
    {
        return $this->tempat_id;
    }

    /**
     * @param mixed $tempat_id
     * @return MTempat
     */
    public function setTempatId($tempat_id)
    {
        $this->tempat_id = $tempat_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatWaktu($format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($this->tempat_waktu));
    }

    /**
     * @param mixed $tempat_waktu
     * @return MTempat
     */
    public function setTempatWaktu($tempat_waktu)
    {
        $this->tempat_waktu = $tempat_waktu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatWaktuUpdate()
    {
        return $this->tempat_waktu_update;
    }

    /**
     * @param mixed $tempat_waktu_update
     * @return MTempat
     */
    public function setTempatWaktuUpdate($tempat_waktu_update)
    {
        $this->tempat_waktu_update = $tempat_waktu_update;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatNama()
    {
        return $this->tempat_nama;
    }

    /**
     * @param mixed $tempat_nama
     * @return MTempat
     */
    public function setTempatNama($tempat_nama)
    {
        $this->tempat_nama = $tempat_nama;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatAlamat($nl2br = false)
    {
        return $nl2br ? nl2br($this->tempat_alamat) : $this->tempat_alamat;
    }

    /**
     * @param mixed $tempat_alamat
     * @return MTempat
     */
    public function setTempatAlamat($tempat_alamat)
    {
        $this->tempat_alamat = $tempat_alamat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatTelpon()
    {
        return $this->tempat_telpon;
    }

    /**
     * @param mixed $tempat_telpon
     * @return MTempat
     */
    public function setTempatTelpon($tempat_telpon)
    {
        $this->tempat_telpon = $tempat_telpon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatPic()
    {
        return $this->tempat_pic;
    }

    /**
     * @param mixed $tempat_pic
     * @return MTempat
     */
    public function setTempatPic($tempat_pic)
    {
        $this->tempat_pic = $tempat_pic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatPicJabatan()
    {
        return $this->tempat_pic_jabatan;
    }

    /**
     * @param mixed $tempat_pic_jabatan
     * @return MTempat
     */
    public function setTempatPicJabatan($tempat_pic_jabatan)
    {
        $this->tempat_pic_jabatan = $tempat_pic_jabatan;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatPicHp()
    {
        return $this->tempat_pic_hp;
    }

    /**
     * @param mixed $tempat_pic_hp
     * @return MTempat
     */
    public function setTempatPicHp($tempat_pic_hp)
    {
        $this->tempat_pic_hp = $tempat_pic_hp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatKeterangan()
    {
        return $this->tempat_keterangan;
    }

    /**
     * @param mixed $tempat_keterangan
     * @return MTempat
     */
    public function setTempatKeterangan($tempat_keterangan)
    {
        $this->tempat_keterangan = $tempat_keterangan;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempatStatus()
    {
        return $this->tempat_status;
    }

    /**
     * @param mixed $tempat_status
     * @return MTempat
     */
    public function setTempatStatus($tempat_status)
    {
        $this->tempat_status = $tempat_status;
        return $this;
    }


}