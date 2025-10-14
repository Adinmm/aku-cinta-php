<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MPesan implements Template
{

    private $pesan_id;
    private $pesan_waktu;
    private $pesan_jenis;
    private $pesan_isi;
    private $pesan_berkas;
    private $pesan_status;
    private $bimbingan_id;

    private $_bimbingan_jenis;
    private $_bimbingan_status;
    private $_mahasiswa_nim;
    private $_mahasiswa_nama;
    private $_mahasiswa_foto;
    private $_dosen_kode;
    private $_dosen_nama;
    private $_dosen_nip;
    private $_dosen_email;
    private $_dosen_foto;

    public function _id()
    {
        return $this->pesan_id;
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
        return Helpers::_empty($this->pesan_id);
    }

    public function _toArray($type = Helpers::type_attribute_all, $exclude = array())
    {
        return Helpers::_to_array(get_object_vars($this), $type, $exclude);
    }

    public function _nama()
    {
        switch ($this->pesan_jenis) {
            case CPesan::_jenis_mahasiswa:
                return $this->_mahasiswa_nama;
            case CPesan::_jenis_dosen:
                return $this->_dosen_nama;
            default:
                return '';
        }
    }

    public function _foto($width = 300, $height = 300)
    {
        switch ($this->pesan_jenis) {
            case CPesan::_jenis_mahasiswa:
                return sprintf('%s/index.php/foto/mahasiswa/%s/%s/%s/%s',
                    SIA_URI, $this->_mahasiswa_nim, $width, $height, md5(time()));
            case CPesan::_jenis_dosen:
                return sprintf('%s/index.php/foto/dosen/%s/%s/%s/%s',
                    SIA_URI, $this->_dosen_kode, $width, $height, md5(time()));
            default:
                return sprintf('%s/logo.png', URI_IMG_PATH);
        }
    }

    /**
     * @return mixed
     */
    public function getPesanId()
    {
        return $this->pesan_id;
    }

    /**
     * @param mixed $pesan_id
     * @return MPesan
     */
    public function setPesanId($pesan_id)
    {
        $this->pesan_id = $pesan_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPesanWaktu($format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($this->pesan_waktu));
    }

    /**
     * @param mixed $pesan_waktu
     * @return MPesan
     */
    public function setPesanWaktu($pesan_waktu)
    {
        $this->pesan_waktu = $pesan_waktu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPesanJenis()
    {
        return $this->pesan_jenis;
    }

    /**
     * @param mixed $pesan_jenis
     * @return MPesan
     */
    public function setPesanJenis($pesan_jenis)
    {
        $this->pesan_jenis = $pesan_jenis;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPesanIsi()
    {
        return nl2br($this->pesan_isi);
    }

    /**
     * @param mixed $pesan_isi
     * @return MPesan
     */
    public function setPesanIsi($pesan_isi)
    {
        $this->pesan_isi = $pesan_isi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPesanBerkas()
    {
        return $this->pesan_berkas;
    }

    /**
     * @param mixed $pesan_berkas
     * @return MPesan
     */
    public function setPesanBerkas($pesan_berkas)
    {
        $this->pesan_berkas = $pesan_berkas;
        return $this;
    }

    public function hasPesanBerkas()
    {
        return !Helpers::_empty($this->pesan_berkas);
    }

    /**
     * @return mixed
     */
    public function getPesanStatus()
    {
        return $this->pesan_status;
    }

    /**
     * @param mixed $pesan_status
     * @return MPesan
     */
    public function setPesanStatus($pesan_status)
    {
        $this->pesan_status = $pesan_status;
        return $this;
    }

    private function isPesanStatus($pesan_status)
    {
        return $this->pesan_status == $pesan_status;
    }

    public function isPesanStatusMenunggu()
    {
        return $this->isPesanStatus(CPesan::_status_menunggu);
    }

    public function isPesanStatusDibaca()
    {
        return $this->isPesanStatus(CPesan::_status_dibaca);
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
     * @return MPesan
     */
    public function setBimbinganId($bimbingan_id)
    {
        $this->bimbingan_id = $bimbingan_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBimbinganJenis()
    {
        return $this->_bimbingan_jenis;
    }

    /**
     * @return mixed
     */
    public function getBimbinganStatus()
    {
        return $this->_bimbingan_status;
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
    public function getMahasiswaFoto()
    {
        return $this->_mahasiswa_foto;
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

    /**
     * @return mixed
     */
    public function getDosenFoto()
    {
        return $this->_dosen_foto;
    }

}