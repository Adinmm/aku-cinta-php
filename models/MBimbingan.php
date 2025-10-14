<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MBimbingan implements Template
{

    private $bimbingan_id;
    private $bimbingan_waktu;
    private $bimbingan_waktu_update;
    private $bimbingan_jenis;
    private $bimbingan_keterangan;
    private $bimbingan_status;
    private $mahasiswa_nim;
    private $dosen_kode;

    private $_mahasiswa_nama;
    private $_mahasiswa_email;
    private $_mahasiswa_foto;
    private $_dosen_nama;
    private $_dosen_nip;
    private $_dosen_email;
    private $_dosen_foto;

    public function _id()
    {
        return $this->bimbingan_id;
    }

    public function _init($request)
    {
        foreach ($request as $field => $value)
            !array_key_exists($field, $this->_toArray())
            || $this->{'set' . Helpers::_camel_case($field, '_', '')}($value);

        return $this;
    }

    public function _empty()
    {
        return Helpers::_empty($this->bimbingan_id);
    }

    public function _toArray($type = Helpers::type_attribute_all, $exclude = array())
    {
        return Helpers::_to_array(get_object_vars($this), $type, $exclude);
    }

    public function _filter()
    {
        !Helpers::_empty($this->bimbingan_status) || $this->bimbingan_status = 0;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBimbinganId()
    {
        return $this->bimbingan_id;
    }

    /**
     * @param mixed $bimbingan_id
     * @return MBimbingan
     */
    public function setBimbinganId($bimbingan_id)
    {
        $this->bimbingan_id = $bimbingan_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBimbinganWaktu()
    {
        return $this->bimbingan_waktu;
    }

    /**
     * @param mixed $bimbingan_waktu
     * @return MBimbingan
     */
    public function setBimbinganWaktu($bimbingan_waktu)
    {
        $this->bimbingan_waktu = $bimbingan_waktu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBimbinganWaktuUpdate()
    {
        return $this->bimbingan_waktu_update;
    }

    /**
     * @param mixed $bimbingan_waktu_update
     * @return MBimbingan
     */
    public function setBimbinganWaktuUpdate($bimbingan_waktu_update)
    {
        $this->bimbingan_waktu_update = $bimbingan_waktu_update;
        return $this;
    }

    /**
     * @param false $label
     * @return array|int|string
     */
    public function getBimbinganJenis($label = false)
    {
        return $label ? Helpers::_arr(CBimbingan::$_jenis, $this->bimbingan_jenis) : $this->bimbingan_jenis;
    }

    /**
     * @param mixed $bimbingan_jenis
     * @return MBimbingan
     */
    public function setBimbinganJenis($bimbingan_jenis)
    {
        $this->bimbingan_jenis = $bimbingan_jenis;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBimbinganKeterangan($limit = 75, $more = '...')
    {
        return $limit < 0 ? $this->bimbingan_keterangan : (substr($this->bimbingan_keterangan, 0, $limit) . (strlen($this->bimbingan_keterangan) > $limit ? $more : ''));
    }

    /**
     * @param mixed $bimbingan_keterangan
     * @return MBimbingan
     */
    public function setBimbinganKeterangan($bimbingan_keterangan)
    {
        $this->bimbingan_keterangan = $bimbingan_keterangan;
        return $this;
    }

    /**
     * @param false $label
     * @return array|int|string
     */
    public function getBimbinganStatus($label = false)
    {
        return $label ? Helpers::_arr(CBimbingan::$_status, $this->bimbingan_status) : $this->bimbingan_status;
    }

    /**
     * @param mixed $bimbingan_status
     * @return MBimbingan
     */
    public function setBimbinganStatus($bimbingan_status)
    {
        $this->bimbingan_status = $bimbingan_status;
        return $this;
    }

    private function isBimbinganStatus($bimbingan_status)
    {
        return $this->bimbingan_status == $bimbingan_status;
    }

    /**
     * @return mixed
     */
    public function getMahasiswaNim()
    {
        return $this->mahasiswa_nim;
    }

    /**
     * @param mixed $mahasiswa_nim
     * @return MBimbingan
     */
    public function setMahasiswaNim($mahasiswa_nim)
    {
        $this->mahasiswa_nim = $mahasiswa_nim;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDosenKode()
    {
        return $this->dosen_kode;
    }

    /**
     * @param mixed $dosen_kode
     * @return MBimbingan
     */
    public function setDosenKode($dosen_kode)
    {
        $this->dosen_kode = $dosen_kode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMahasiswaNama()
    {
        return $this->_mahasiswa_nama;
    }

    /**
     * @return mixed
     */
    public function getMahasiswaEmail()
    {
        return $this->_mahasiswa_email;
    }

    public function hasMahasiswaFoto()
    {
        return !Helpers::_empty($this->_mahasiswa_foto);
    }

    public function getMahasiswaFoto($width = 300, $height = 300)
    {
        return $this->hasMahasiswaFoto()
            ? sprintf('%s/index.php/foto/mahasiswa/%s/%s/%s/%s',
                SIA_URI, $this->mahasiswa_nim, $width, $height, md5(time())) :
            sprintf('%s/logo.png', URI_IMG_PATH);
    }

    /**
     * @return mixed
     */
    public function getDosenNama()
    {
        return $this->_dosen_nama;
    }

    /**
     * @return mixed
     */
    public function getDosenNip()
    {
        return $this->_dosen_nip;
    }

    /**
     * @return mixed
     */
    public function getDosenEmail()
    {
        return $this->_dosen_email;
    }

    public function hasDosenFoto()
    {
        return !Helpers::_empty($this->_dosen_foto);
    }

    public function getDosenFoto($width = 300, $height = 300)
    {
        return $this->hasDosenFoto()
            ? sprintf('%s/index.php/foto/dosen/%s/%s/%s/%s',
                SIA_URI, $this->dosen_kode, $width, $height, md5(time())) :
            sprintf('%s/logo.png', URI_IMG_PATH);
    }

}