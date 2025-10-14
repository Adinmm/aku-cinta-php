<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MPengajuan implements Template
{

    private $pengajuan_id;
    private $pengajuan_waktu;
    private $pengajuan_waktu_update;
    private $pengajuan_tahun_akademik;
    private $pengajuan_bimbingan_tanggal_mulai;
    private $pengajuan_bimbingan_tanggal_selesai;
    private $pengajuan_nomor;
    private $pengajuan_nomor_ext;
    private $pengajuan_data;
    private $pengajuan_upload;
    private $pengajuan_ttd;
    private $pengajuan_status;
    private $pengantar_id;
    private $dosen_kode;

    private $_mahasiswa_nim;
    private $_mahasiswa_nama;
    private $_tempat_id;
    private $_tempat_nama;
    private $_tempat_alamat;
    private $_dosen_nama;
    private $_dosen_nip;

    public function _id()
    {
        return $this->pengajuan_id;
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
        return Helpers::_empty($this->pengajuan_id);
    }

    public function _filter()
    {
        !Helpers::_empty($this->pengajuan_status) || $this->pengajuan_status = 0;
        return $this;
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
     * @return MPengajuan
     */
    public function setPengajuanId($pengajuan_id)
    {
        $this->pengajuan_id = $pengajuan_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengajuanWaktu()
    {
        return $this->pengajuan_waktu;
    }

    /**
     * @param mixed $pengajuan_waktu
     * @return MPengajuan
     */
    public function setPengajuanWaktu($pengajuan_waktu)
    {
        $this->pengajuan_waktu = $pengajuan_waktu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengajuanWaktuUpdate()
    {
        return $this->pengajuan_waktu_update;
    }

    /**
     * @param mixed $pengajuan_waktu_update
     * @return MPengajuan
     */
    public function setPengajuanWaktuUpdate($pengajuan_waktu_update)
    {
        $this->pengajuan_waktu_update = $pengajuan_waktu_update;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengajuanTahunAkademik()
    {
        return $this->pengajuan_tahun_akademik;
    }

    /**
     * @param mixed $pengajuan_tahun_akademik
     * @return MPengajuan
     */
    public function setPengajuanTahunAkademik($pengajuan_tahun_akademik)
    {
        $this->pengajuan_tahun_akademik = $pengajuan_tahun_akademik;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengajuanBimbinganTanggalMulai()
    {
        return $this->pengajuan_bimbingan_tanggal_mulai;
    }

    /**
     * @param mixed $pengajuan_bimbingan_tanggal_mulai
     * @return MPengajuan
     */
    public function setPengajuanBimbinganTanggalMulai($pengajuan_bimbingan_tanggal_mulai)
    {
        $this->pengajuan_bimbingan_tanggal_mulai = $pengajuan_bimbingan_tanggal_mulai;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengajuanBimbinganTanggalSelesai()
    {
        return $this->pengajuan_bimbingan_tanggal_selesai;
    }

    /**
     * @param mixed $pengajuan_bimbingan_tanggal_selesai
     * @return MPengajuan
     */
    public function setPengajuanBimbinganTanggalSelesai($pengajuan_bimbingan_tanggal_selesai)
    {
        $this->pengajuan_bimbingan_tanggal_selesai = $pengajuan_bimbingan_tanggal_selesai;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPengajuanNomor($with_ext = false)
    {
        return trim($this->pengajuan_nomor) . ($with_ext ? $this->pengajuan_nomor_ext : '');
    }

    /**
     * @param mixed $pengajuan_nomor
     * @return MPengajuan
     */
    public function setPengajuanNomor($pengajuan_nomor)
    {
        $this->pengajuan_nomor = $pengajuan_nomor;
        return $this;
    }

    public function hasPengajuanNomor()
    {
        return !Helpers::_empty($this->pengajuan_nomor);
    }

    /**
     * @return mixed
     */
    public function getPengajuanNomorExt()
    {
        return $this->pengajuan_nomor_ext;
    }

    /**
     * @param mixed $pengajuan_nomor_ext
     * @return MPengajuan
     */
    public function setPengajuanNomorExt($pengajuan_nomor_ext)
    {
        $this->pengajuan_nomor_ext = $pengajuan_nomor_ext;
        return $this;
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPengajuan|mixed
     */
    public function getPengajuanData($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->pengajuan_data, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->pengajuan_data;
    }

    public function hasPengajuanData()
    {
        return !Helpers::_empty($this->pengajuan_data);
    }

    /**
     * @param $pengajuan_data
     * @param bool $encode
     * @return MPengajuan
     */
    public function setPengajuanData($pengajuan_data, $encode = true)
    {
        $this->pengajuan_data = $encode ? json_encode($pengajuan_data) : $pengajuan_data;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPengajuanData($key, $value)
    {
        $_tmp = $this->getPengajuanData('array', '', []);
        $_tmp[$key] = $value;
        $this->setPengajuanData($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPengajuan|mixed
     */
    public function getPengajuanUpload($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->pengajuan_upload, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->pengajuan_upload;
    }

    public function hasPengajuanUpload()
    {
        return !Helpers::_empty($this->pengajuan_upload);
    }

    /**
     * @param $pengajuan_upload
     * @param bool $encode
     * @return MPengajuan
     */
    public function setPengajuanUpload($pengajuan_upload, $encode = true)
    {
        $this->pengajuan_upload = $encode ? json_encode($pengajuan_upload) : $pengajuan_upload;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPengajuanUpload($key, $value)
    {
        $_tmp = $this->getPengajuanUpload('array', '', []);
        $_tmp[$key] = $value;
        $this->setPengajuanUpload($_tmp);
    }

    /**
     * @param string $format
     * @param string $key
     * @param string $default
     * @return MPengajuan|mixed
     */
    public function getPengajuanTtd($format = 'json', $key = '', $default = '')
    {
        if ($format == 'array') {
            $_tmp = json_decode($this->pengajuan_ttd, true);
            return $key ? Helpers::_arr($_tmp, $key, $default) : $_tmp;
        } else return $this->pengajuan_ttd;
    }

    public function hasPengajuanTtd()
    {
        return !Helpers::_empty($this->pengajuan_ttd);
    }

    /**
     * @param $pengajuan_ttd
     * @param bool $encode
     * @return MPengajuan
     */
    public function setPengajuanTtd($pengajuan_ttd, $encode = true)
    {
        $this->pengajuan_ttd = $encode ? json_encode($pengajuan_ttd) : $pengajuan_ttd;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPengajuanTtd($key, $value)
    {
        $_tmp = $this->getPengajuanTtd('array', '', []);
        $_tmp[$key] = $value;
        $this->setPengajuanTtd($_tmp);
    }

    /**
     * @return mixed
     */
    public function getPengajuanStatus()
    {
        return $this->pengajuan_status;
    }

    /**
     * @param mixed $pengajuan_status
     * @return MPengajuan
     */
    public function setPengajuanStatus($pengajuan_status)
    {
        $this->pengajuan_status = $pengajuan_status;
        return $this;
    }

    public function isPengajuanStatus($status)
    {
        return $this->pengajuan_status == $status;
    }

    public function isPengajuanStatusMenunggu()
    {
        return $this->isPengajuanStatus(CStatus::_status_menunggu);
    }

    public function isPengajuanStatusDiajukan()
    {
        return $this->isPengajuanStatus(CStatus::_status_diajukan);
    }

    public function isPengajuanStatusDiterima()
    {
        return $this->isPengajuanStatus(CStatus::_status_diterima);
    }

    public function isPengajuanStatusDitolak()
    {
        return $this->isPengajuanStatus(CStatus::_status_ditolak);
    }

    public function isPengajuanStatusSelesai()
    {
        return $this->isPengajuanStatus(CStatus::_status_selesai);
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
     * @return MPengajuan
     */
    public function setPengantarId($pengantar_id)
    {
        $this->pengantar_id = $pengantar_id;
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
     * @return MPengajuan
     */
    public function setDosenKode($dosen_kode)
    {
        $this->dosen_kode = $dosen_kode;
        return $this;
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
    public function getDosenNip($fallback = '')
    {
        return $fallback && Helpers::_empty($this->_dosen_nip) ? $fallback : $this->_dosen_nip;
    }

    public function getTaKeteranganESign($prefix)
    {
        return sprintf('%s PKL untuk %s (%s) tahun akademik %s',
            $prefix, $this->_dosen_nama, $this->dosen_kode,
            Helpers::_parse_tahun_akademik($this->pengajuan_tahun_akademik));
    }

}