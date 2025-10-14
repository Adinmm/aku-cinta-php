<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MPengantar implements Template
{

    private $pengantar_id;
    private $pengantar_waktu;
    private $pengantar_waktu_update;
    private $pengantar_tahun_akademik;
    private $pengantar_tanggal_mulai;
    private $pengantar_tanggal_selesai;
    private $pengantar_judul;
    private $pengantar_topik;
    private $pengantar_nomor;
    private $pengantar_nomor_ext;
    private $pengantar_data;
    private $pengantar_upload;
    private $pengantar_ttd;
    private $pengantar_status;
    private $mahasiswa_nim;
    private $tempat_id;

    private $_mahasiswa_nama;
    private $_tempat_nama;
    private $_tempat_alamat;

    public function _id()
    {
        return $this->pengantar_id;
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
        return Helpers::_empty($this->pengantar_id);
    }

    public function _filter()
    {
        !Helpers::_empty($this->pengantar_status) || $this->pengantar_status = 0;
        return $this;
    }

    public function _passRequiredFields()
    {
        return !(Helpers::_empty($this->pengantar_tanggal_mulai)
            || Helpers::_empty($this->pengantar_tanggal_selesai));
    }

    /**
     * @return mixed
     */
    public function getPengantarId()
    {
        return $this->pengantar_id;
    }

    /**
     * @param mixed $pengantar_id
     * @return MPengantar
     */
    public function setPengantarId($pengantar_id)
    {
        $this->pengantar_id = $pengantar_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengantarWaktu()
    {
        return $this->pengantar_waktu;
    }

    /**
     * @param mixed $pengantar_waktu
     * @return MPengantar
     */
    public function setPengantarWaktu($pengantar_waktu)
    {
        $this->pengantar_waktu = $pengantar_waktu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengantarWaktuUpdate()
    {
        return $this->pengantar_waktu_update;
    }

    /**
     * @param mixed $pengantar_waktu_update
     * @return MPengantar
     */
    public function setPengantarWaktuUpdate($pengantar_waktu_update)
    {
        $this->pengantar_waktu_update = $pengantar_waktu_update;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengantarTahunAkademik()
    {
        return $this->pengantar_tahun_akademik;
    }

    /**
     * @param mixed $pengantar_tahun_akademik
     * @return MPengantar
     */
    public function setPengantarTahunAkademik($pengantar_tahun_akademik)
    {
        $this->pengantar_tahun_akademik = $pengantar_tahun_akademik;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengantarTanggalMulai($format = 'Y-m-d')
    {
        return date($format, strtotime($this->pengantar_tanggal_mulai));
    }

    /**
     * @param mixed $pengantar_tanggal_mulai
     * @return MPengantar
     */
    public function setPengantarTanggalMulai($pengantar_tanggal_mulai)
    {
        $this->pengantar_tanggal_mulai = $pengantar_tanggal_mulai;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengantarTanggalSelesai($format = 'Y-m-d')
    {
        return date($format, strtotime($this->pengantar_tanggal_selesai));
    }

    /**
     * @param mixed $pengantar_tanggal_selesai
     * @return MPengantar
     */
    public function setPengantarTanggalSelesai($pengantar_tanggal_selesai)
    {
        $this->pengantar_tanggal_selesai = $pengantar_tanggal_selesai;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengantarJudul()
    {
        return $this->pengantar_judul;
    }

    /**
     * @param mixed $pengantar_judul
     * @return MPengantar
     */
    public function setPengantarJudul($pengantar_judul)
    {
        $this->pengantar_judul = $pengantar_judul;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengantarTopik()
    {
        return $this->pengantar_topik;
    }

    /**
     * @param mixed $pengantar_topik
     * @return MPengantar
     */
    public function setPengantarTopik($pengantar_topik)
    {
        $this->pengantar_topik = $pengantar_topik;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengantarNomor($with_ext = false, $prefill = '')
    {
        return ($with_ext && !$this->pengantar_nomor ? $prefill : $this->pengantar_nomor) . ($with_ext ? $this->pengantar_nomor_ext : '');
    }

    /**
     * @param mixed $pengantar_nomor
     * @return MPengantar
     */
    public function setPengantarNomor($pengantar_nomor)
    {
        $this->pengantar_nomor = $pengantar_nomor;
        return $this;
    }

    public function hasPengantarNomor()
    {
        return !Helpers::_empty($this->pengantar_nomor);
    }

    /**
     * @return mixed
     */
    public function getPengantarNomorExt()
    {
        return $this->pengantar_nomor_ext;
    }

    /**
     * @param mixed $pengantar_nomor_ext
     * @return MPengantar
     */
    public function setPengantarNomorExt($pengantar_nomor_ext)
    {
        $this->pengantar_nomor_ext = $pengantar_nomor_ext;
        return $this;
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPengantar|mixed
     */
    public function getPengantarData($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->pengantar_data, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->pengantar_data;
    }

    public function hasPengantarData()
    {
        return !Helpers::_empty($this->pengantar_data);
    }

    /**
     * @param $pengantar_data
     * @param bool $encode
     * @return MPengantar
     */
    public function setPengantarData($pengantar_data, $encode = true)
    {
        $this->pengantar_data = $encode ? json_encode($pengantar_data) : $pengantar_data;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPengantarData($key, $value)
    {
        $_tmp = $this->getPengantarData('array', '', []);
        $_tmp[$key] = $value;
        $this->setPengantarData($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPengantar|mixed
     */
    public function getPengantarUpload($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->pengantar_upload, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->pengantar_upload;
    }

    public function hasPengantarUpload()
    {
        return !Helpers::_empty($this->pengantar_upload);
    }

    /**
     * @param $pengantar_upload
     * @param bool $encode
     * @return MPengantar
     */
    public function setPengantarUpload($pengantar_upload, $encode = true)
    {
        $this->pengantar_upload = $encode ? json_encode($pengantar_upload) : $pengantar_upload;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPengantarUpload($key, $value)
    {
        $_tmp = $this->getPengantarUpload('array', '', []);
        $_tmp[$key] = $value;
        $this->setPengantarUpload($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPengantar|mixed
     */
    public function getPengantarTtd($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->pengantar_ttd, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->pengantar_ttd;
    }

    public function hasPengantarTtd()
    {
        return !Helpers::_empty($this->pengantar_ttd);
    }

    /**
     * @param $pengantar_ttd
     * @param bool $encode
     * @return MPengantar
     */
    public function setPengantarTtd($pengantar_ttd, $encode = true)
    {
        $this->pengantar_ttd = $encode ? json_encode($pengantar_ttd) : $pengantar_ttd;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPengantarTtd($key, $value)
    {
        $_tmp = $this->getPengantarTtd('array', '', []);
        $_tmp[$key] = $value;
        $this->setPengantarTtd($_tmp);
    }

    /**
     * @return mixed
     */
    public function getPengantarStatus()
    {
        return $this->pengantar_status;
    }

    /**
     * @param mixed $pengantar_status
     * @return MPengantar
     */
    public function setPengantarStatus($pengantar_status)
    {
        $this->pengantar_status = $pengantar_status;
        return $this;
    }

    public function isPengantarStatus($status)
    {
        return $this->pengantar_status == $status;
    }

    public function isPengantarStatusMenunggu()
    {
        return $this->isPengantarStatus(CStatus::_status_menunggu);
    }

    public function isPengantarStatusDiajukan()
    {
        return $this->isPengantarStatus(CStatus::_status_diajukan);
    }

    public function isPengantarStatusDiterima()
    {
        return $this->isPengantarStatus(CStatus::_status_diterima);
    }

    public function isPengantarStatusDitolak()
    {
        return $this->isPengantarStatus(CStatus::_status_ditolak);
    }

    public function isPengantarStatusSelesai()
    {
        return $this->isPengantarStatus(CStatus::_status_selesai);
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
     * @return MPengantar
     */
    public function setMahasiswaNim($mahasiswa_nim)
    {
        $this->mahasiswa_nim = $mahasiswa_nim;
        return $this;
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
     * @return MPengantar
     */
    public function setTempatId($tempat_id)
    {
        $this->tempat_id = $tempat_id;
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

    public function getTaKeteranganESign()
    {
        return sprintf('Pengantar PKL dari %s (%s) tahun akademik %s',
            $this->_mahasiswa_nama, $this->mahasiswa_nim,
            Helpers::_parse_tahun_akademik($this->pengantar_tahun_akademik));
    }

}