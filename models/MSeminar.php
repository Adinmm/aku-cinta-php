<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MSeminar implements Template
{

    private $seminar_id;
    private $seminar_waktu;
    private $seminar_waktu_update;
    private $seminar_judul;
    private $seminar_jam;
    private $seminar_tanggal;
    private $seminar_tempat;
    private $seminar_nomor;
    private $seminar_status;
    private $seminar_data;
    private $seminar_nilai;
    private $seminar_upload;
    private $seminar_ttd;
    private $pengajuan_id;

    private $_mahasiswa_nim;
    private $_mahasiswa_nama;
    private $_tempat_id;
    private $_tempat_nama;
    private $_tempat_alamat;
    private $_dosen_kode;
    private $_dosen_nama;
    private $_dosen_email;
    private $_dosen_nip;

    public function _id()
    {
        return $this->seminar_id;
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
        return Helpers::_empty($this->seminar_id);
    }

    public function _filter()
    {
        !Helpers::_empty($this->seminar_status) || $this->seminar_status = 0;
        !Helpers::_empty($this->seminar_tanggal) || $this->seminar_tanggal = '9999-01-01';
        return $this;
    }

    public function _passRequiredFields()
    {
        return !(Helpers::_empty($this->seminar_tanggal)
            || Helpers::_empty($this->seminar_waktu)
            || Helpers::_empty($this->seminar_tempat));
    }

    /**
     * @return mixed
     */
    public function getSeminarId()
    {
        return $this->seminar_id;
    }

    /**
     * @param mixed $seminar_id
     * @return MSeminar
     */
    public function setSeminarId($seminar_id)
    {
        $this->seminar_id = $seminar_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeminarWaktu()
    {
        return $this->seminar_waktu;
    }

    /**
     * @param mixed $seminar_waktu
     * @return MSeminar
     */
    public function setSeminarWaktu($seminar_waktu)
    {
        $this->seminar_waktu = $seminar_waktu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeminarWaktuUpdate()
    {
        return $this->seminar_waktu_update;
    }

    /**
     * @param mixed $seminar_waktu_update
     * @return MSeminar
     */
    public function setSeminarWaktuUpdate($seminar_waktu_update)
    {
        $this->seminar_waktu_update = $seminar_waktu_update;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeminarJudul()
    {
        return $this->seminar_judul;
    }

    /**
     * @param mixed $seminar_judul
     * @return MSeminar
     */
    public function setSeminarJudul($seminar_judul)
    {
        $this->seminar_judul = $seminar_judul;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeminarJam()
    {
        return $this->seminar_jam;
    }

    /**
     * @param mixed $seminar_jam
     * @return MSeminar
     */
    public function setSeminarJam($seminar_jam)
    {
        $this->seminar_jam = $seminar_jam;
        return $this;
    }

//    /**
//     * @param string $format
//     * @return mixed
//     */
//    public function getSeminarTanggal($format = 'Y-m-d')
//    {
//        return date($format, strtotime($this->seminar_tanggal));
//    }

    /**
     * @param string $format
     * @return mixed
     */
    public function getSeminarTanggal($format = 'Y-m-d')
    {
        return $this->seminar_tanggal == '9999-01-01' || $this->seminar_tanggal == '1000-01-01' || $this->seminar_tanggal == '1970-01-01' ? '' : date($format, strtotime($this->seminar_tanggal));
    }

    /**
     * @param mixed $seminar_tanggal
     * @return MSeminar
     */
    public function setSeminarTanggal($seminar_tanggal)
    {
        $this->seminar_tanggal = $seminar_tanggal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeminarTempat()
    {
        return $this->seminar_tempat;
    }

    /**
     * @param mixed $seminar_tempat
     * @return MSeminar
     */
    public function setSeminarTempat($seminar_tempat)
    {
        $this->seminar_tempat = $seminar_tempat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeminarNomor()
    {
        return $this->seminar_nomor;
    }

    public function hasSeminarNomor()
    {
        return !Helpers::_empty($this->seminar_nomor);
    }

    /**
     * @param mixed $seminar_nomor
     * @return MSeminar
     */
    public function setSeminarNomor($seminar_nomor)
    {
        $this->seminar_nomor = $seminar_nomor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeminarStatus()
    {
        return $this->seminar_status;
    }

    /**
     * @param mixed $seminar_status
     * @return MSeminar
     */
    public function setSeminarStatus($seminar_status)
    {
        $this->seminar_status = $seminar_status;
        return $this;
    }

    public function isSeminarStatus($status)
    {
        return $this->seminar_status == $status;
    }

    public function isSeminarStatusMenunggu()
    {
        return $this->isSeminarStatus(CStatus::_status_menunggu);
    }

    public function isSeminarStatusDitolak()
    {
        return $this->isSeminarStatus(CStatus::_status_ditolak);
    }

    public function isSeminarStatusDiterima()
    {
        return $this->isSeminarStatus(CStatus::_status_diterima);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MSeminar|mixed
     */
    public function getSeminarData($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->seminar_data, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->seminar_data;
    }

    public function hasSeminarData()
    {
        return !Helpers::_empty($this->seminar_data);
    }

    /**
     * @param $seminar_data
     * @param bool $encode
     * @return MSeminar
     */
    public function setSeminarData($seminar_data, $encode = true)
    {
        $this->seminar_data = $encode ? json_encode($seminar_data) : $seminar_data;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addSeminarData($key, $value)
    {
        $_tmp = $this->getSeminarData('array', '', []);
        $_tmp[$key] = $value;
        $this->setSeminarData($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MSeminar|mixed
     */
    public function getSeminarNilai($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->seminar_nilai, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->seminar_nilai;
    }

    public function hasSeminarNilai()
    {
        return !Helpers::_empty($this->seminar_nilai);
    }

    /**
     * @param $seminar_nilai
     * @param bool $encode
     * @return MSeminar
     */
    public function setSeminarNilai($seminar_nilai, $encode = true)
    {
        $this->seminar_nilai = $encode ? json_encode($seminar_nilai) : $seminar_nilai;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addSeminarNilai($key, $value)
    {
        $_tmp = $this->getSeminarNilai('array', '', []);
        $_tmp[$key] = $value;
        $this->setSeminarNilai($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MSeminar|mixed
     */
    public function getSeminarUpload($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->seminar_upload, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->seminar_upload;
    }

    public function hasSeminarUpload()
    {
        return !Helpers::_empty($this->seminar_upload);
    }

    /**
     * @param $seminar_upload
     * @param bool $encode
     * @return MSeminar
     */
    public function setSeminarUpload($seminar_upload, $encode = true)
    {
        $this->seminar_upload = $encode ? json_encode($seminar_upload) : $seminar_upload;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addSeminarUpload($key, $value)
    {
        $_tmp = $this->getSeminarUpload('array', '', []);
        $_tmp[$key] = $value;
        $this->setSeminarUpload($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MSeminar|mixed
     */
    public function getSeminarTtd($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->seminar_ttd, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->seminar_ttd;
    }

    public function hasSeminarTtd()
    {
        return !Helpers::_empty($this->seminar_ttd);
    }

    /**
     * @param $seminar_ttd
     * @param bool $encode
     * @return MSeminar
     */
    public function setSeminarTtd($seminar_ttd, $encode = true)
    {
        $this->seminar_ttd = $encode ? json_encode($seminar_ttd) : $seminar_ttd;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addSeminarTtd($key, $value)
    {
        $_tmp = $this->getSeminarTtd('array', '', []);
        $_tmp[$key] = $value;
        $this->setSeminarTtd($_tmp);
    }

    /**
     * @return mixed
     */
    public function getPengajuanId()
    {
        return $this->pengajuan_id;
    }

    /**
     * @param mixed $pengajuan_id
     * @return MSeminar
     */
    public function setPengajuanId($pengajuan_id)
    {
        $this->pengajuan_id = $pengajuan_id;
        return $this;
    }

    public function getTaKeteranganESign()
    {
        return sprintf('Berita Acara Seminar PKL oleh mahasiswa %s (%s) - Dosen Pembimbing %s (%s)',
            $this->_mahasiswa_nama, $this->_mahasiswa_nim, $this->_dosen_nama, $this->_dosen_kode);
    }

    /**
     * @return mixed
     */
    public function getMahasiswaNim()
    {
        return $this->_mahasiswa_nim;
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
    public function getTempatId()
    {
        return $this->_tempat_id;
    }

    /**
     * @return mixed
     */
    public function getTempatNama()
    {
        return $this->_tempat_nama;
    }

    /**
     * @return mixed
     */
    public function getTempatAlamat()
    {
        return $this->_tempat_alamat;
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
     * @return mixed
     */
    public function getDosenEmail()
    {
        return $this->_dosen_email;
    }

    /**
     * @return mixed
     */
    public function getDosenNip()
    {
        return $this->_dosen_nip;
    }

}