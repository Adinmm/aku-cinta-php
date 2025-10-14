<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MPersetujuan implements Template
{

    private $persetujuan_id;
    private $persetujuan_waktu;
    private $persetujuan_waktu_update;
    private $persetujuan_tahun_akademik;
    private $persetujuan_status;
    private $persetujuan_data;
    private $persetujuan_upload;
    private $persetujuan_ttd;
    private $mahasiswa_nim;

    private $_mahasiswa_nama;
    private $_dosen_kode;
    private $_dosen_nama;
    private $_dosen_nip;
    private $_dosen_email;


    public function _id()
    {
        return $this->persetujuan_id;
    }

    public function _init($request)
    {
        foreach ($request as $field => $value)
            !array_key_exists($field, $this->_toArray(Helpers::type_attribute_primary))
            || $this->{'set' . Helpers::_camel_case($field, '_', '')}($request[$field]);

        return $this;
    }

    public function _toArray($type = Helpers::type_attribute_all, $exclude = array())
    {
        return Helpers::_to_array(get_object_vars($this), $type, $exclude);
    }

    public function _empty()
    {
        return Helpers::_empty($this->persetujuan_id);
    }

    public function _filter()
    {
        !Helpers::_empty($this->persetujuan_status) || $this->persetujuan_status = 0;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersetujuanId()
    {
        return $this->persetujuan_id;
    }

    /**
     * @param mixed $persetujuan_id
     * @return MPersetujuan
     */
    public function setPersetujuanId($persetujuan_id)
    {
        $this->persetujuan_id = $persetujuan_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersetujuanWaktu()
    {
        return $this->persetujuan_waktu;
    }

    /**
     * @param mixed $persetujuan_waktu
     * @return MPersetujuan
     */
    public function setPersetujuanWaktu($persetujuan_waktu)
    {
        $this->persetujuan_waktu = $persetujuan_waktu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersetujuanWaktuUpdate()
    {
        return $this->persetujuan_waktu_update;
    }

    /**
     * @param mixed $persetujuan_waktu_update
     * @return MPersetujuan
     */
    public function setPersetujuanWaktuUpdate($persetujuan_waktu_update)
    {
        $this->persetujuan_waktu_update = $persetujuan_waktu_update;
        return $this;
    }

    /**
     * @param bool $parse
     * @return mixed
     */
    public function getPersetujuanTahunAkademik($parse = false)
    {
        return $parse ? Helpers::_parse_tahun_akademik($this->persetujuan_tahun_akademik) : $this->persetujuan_tahun_akademik;
    }

    /**
     * @param mixed $persetujuan_tahun_akademik
     * @return MPersetujuan
     */
    public function setPersetujuanTahunAkademik($persetujuan_tahun_akademik)
    {
        $this->persetujuan_tahun_akademik = $persetujuan_tahun_akademik;
        return $this;
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
     * @return MPersetujuan
     */
    public function setMahasiswaNim($mahasiswa_nim)
    {
        $this->mahasiswa_nim = $mahasiswa_nim;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersetujuanStatus()
    {
        return $this->persetujuan_status;
    }

    /**
     * @param mixed $persetujuan_status
     * @return MPersetujuan
     */
    public function setPersetujuanStatus($persetujuan_status)
    {
        $this->persetujuan_status = $persetujuan_status;
        return $this;
    }

    public function isPersetujuanStatus($status)
    {
        return $this->persetujuan_status == $status;
    }

    public function isPersetujuanStatusMenunggu()
    {
        return $this->isPersetujuanStatus(CStatus::_status_menunggu);
    }

    public function isPersetujuanStatusDiajukan()
    {
        return $this->isPersetujuanStatus(CStatus::_status_diajukan);
    }

    public function isPersetujuanStatusDiterima()
    {
        return $this->isPersetujuanStatus(CStatus::_status_diterima);
    }

    public function isPersetujuanStatusDitolak()
    {
        return $this->isPersetujuanStatus(CStatus::_status_ditolak);
    }

    public function isPersetujuanStatusSelesai()
    {
        return $this->isPersetujuanStatus(CStatus::_status_selesai);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPersetujuan|mixed
     */
    public function getPersetujuanData($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->persetujuan_data, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->persetujuan_data;
    }

    public function hasPersetujuanData()
    {
        return !Helpers::_empty($this->persetujuan_data);
    }

    /**
     * @param $persetujuan_data
     * @param bool $encode
     * @return MPersetujuan
     */
    public function setPersetujuanData($persetujuan_data, $encode = true)
    {
        $this->persetujuan_data = $encode ? json_encode($persetujuan_data) : $persetujuan_data;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPersetujuanData($key, $value)
    {
        $_tmp = $this->getPersetujuanData('array', '', []);
        $_tmp[$key] = $value;
        $this->setPersetujuanData($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPersetujuan|mixed
     */
    public function getPersetujuanUpload($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->persetujuan_upload, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->persetujuan_upload;
    }

    public function hasPersetujuanUpload()
    {
        return !Helpers::_empty($this->persetujuan_upload);
    }

    /**
     * @param $persetujuan_upload
     * @param bool $encode
     * @return MPersetujuan
     */
    public function setPersetujuanUpload($persetujuan_upload, $encode = true)
    {
        $this->persetujuan_upload = $encode ? json_encode($persetujuan_upload) : $persetujuan_upload;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPersetujuanUpload($key, $value)
    {
        $_tmp = $this->getPersetujuanUpload('array', '', []);
        $_tmp[$key] = $value;
        $this->setPersetujuanUpload($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPersetujuan|mixed
     */
    public function getPersetujuanTtd($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->persetujuan_ttd, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->persetujuan_ttd;
    }

    public function hasPersetujuanTtd()
    {
        return !Helpers::_empty($this->persetujuan_ttd);
    }

    /**
     * @param $persetujuan_ttd
     * @param bool $encode
     * @return MPersetujuan
     */
    public function setPersetujuanTtd($persetujuan_ttd, $encode = true)
    {
        $this->persetujuan_ttd = $encode ? json_encode($persetujuan_ttd) : $persetujuan_ttd;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPersetujuanTtd($key, $value)
    {
        $_tmp = $this->getPersetujuanTtd('array', '', []);
        $_tmp[$key] = $value;
        $this->setPersetujuanTtd($_tmp);
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
    public function getDosenKode()
    {
        return $this->_dosen_kode;
    }

    /**
     * @return mixed
     */
    public function getDosenNama()
    {
        return $this->_dosen_nama;
    }

    /**
     * @return bool
     */
    public function hasDosenNama()
    {
        return !Helpers::_empty($this->_dosen_nama);
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

    public function getTaKeteranganESign()
    {
        return sprintf('Persetujuan PKL dari %s (%s) tahun akademik %s',
            $this->_mahasiswa_nama, $this->mahasiswa_nim,
            Helpers::_parse_tahun_akademik($this->persetujuan_tahun_akademik));
    }

}