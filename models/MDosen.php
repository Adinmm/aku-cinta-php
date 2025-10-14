<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MDosen implements Template
{

    private $dosen_kode;
    private $dosen_nip;
    private $dosen_nidn;
    private $dosen_nama;
    private $dosen_nomor_hp;
    private $dosen_email;
    private $dosen_foto;
    private $dosen_status;
    private $prodi_id;

    private $_prodi_nama;
    private $_pembimbing;
    private $_pembimbing_berlangsung;
    private $_pembimbing_selesai;

    public function _id()
    {
        return $this->dosen_kode;
    }

    public function _init($request)
    {
        foreach ($request as $field => $value)
            !array_key_exists($field, $this->_toArray())
            || $this->{'set' . Helpers::_camel_case($field, '_', '')}($request[$field]);

        return $this;
    }

    public function _empty()
    {
        return Helpers::_empty($this->dosen_kode);
    }

    public function _toArray($type = Helpers::type_attribute_all, $exclude = array())
    {
        return Helpers::_to_array(get_object_vars($this), $type, $exclude);
    }

    public function _init_SIA($dosen_kode = '')
    {
        $dosen_kode || $dosen_kode = $this->dosen_kode;
        $arr_dosen = CDosen::_gi()->_get_sia($dosen_kode);
        return $this
            ->setDosenNama(Helpers::_arr($arr_dosen, 'nama'))
            ->setDosenNip(Helpers::_arr($arr_dosen, 'NIP'))
            ->setDosenNidn(Helpers::_arr($arr_dosen, 'NIDN'))
            ->setDosenNomorHp(Helpers::_arr($arr_dosen, 'tlp_hp'))
            ->setDosenEmail(Helpers::_arr($arr_dosen, 'email'))
            ->setDosenFoto(Helpers::_arr($arr_dosen, 'foto'))
            ->setDosenStatus(Helpers::_arr($arr_dosen, 'kode_status_dosen'))
            ->setProdiId(Helpers::_arr($arr_dosen, 'kode_PS'));
    }

    public function _filter()
    {
        !Helpers::_empty($this->dosen_status) || $this->dosen_status = 0;
        !Helpers::_empty($this->prodi_id) || $this->prodi_id = 0;

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
     * @return MDosen
     */
    public function setDosenKode($dosen_kode)
    {
        $this->dosen_kode = $dosen_kode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDosenNip()
    {
        return $this->dosen_nip;
    }

    /**
     * @param mixed $dosen_nip
     * @return MDosen
     */
    public function setDosenNip($dosen_nip)
    {
        $this->dosen_nip = $dosen_nip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDosenNidn()
    {
        return $this->dosen_nidn;
    }

    /**
     * @param mixed $dosen_nidn
     * @return MDosen
     */
    public function setDosenNidn($dosen_nidn)
    {
        $this->dosen_nidn = $dosen_nidn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDosenNama()
    {
        return $this->dosen_nama;
    }

    /**
     * @param mixed $dosen_nama
     * @return MDosen
     */
    public function setDosenNama($dosen_nama)
    {
        $this->dosen_nama = $dosen_nama;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDosenNomorHp()
    {
        return $this->dosen_nomor_hp;
    }

    /**
     * @param mixed $dosen_nomor_hp
     * @return MDosen
     */
    public function setDosenNomorHp($dosen_nomor_hp)
    {
        $this->dosen_nomor_hp = $dosen_nomor_hp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDosenEmail()
    {
        return $this->dosen_email;
    }

    /**
     * @param mixed $dosen_email
     * @return MDosen
     */
    public function setDosenEmail($dosen_email)
    {
        $this->dosen_email = $dosen_email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDosenFoto()
    {
        return $this->dosen_foto;
    }

    /**
     * @param mixed $dosen_foto
     * @return MDosen
     */
    public function setDosenFoto($dosen_foto)
    {
        $this->dosen_foto = $dosen_foto;
        return $this;
    }

    public function hasDosenFoto()
    {
        return !Helpers::_empty($this->dosen_foto);
    }

    public function getDosenFoto2($width = 300, $height = 300)
    {
        return $this->hasDosenFoto()
            ? sprintf('%s/index.php/foto/dosen/%s/%s/%s/%s',
                SIA_URI, $this->dosen_kode, $width, $height, md5(time())) :
            sprintf('%s/logo.png', URI_IMG_PATH);
    }

    /**
     * @return mixed
     */
    public function getDosenStatus($label = false)
    {
        return $label ? Helpers::_arr(CDosen::$_status, $this->dosen_status) : $this->dosen_status;
    }

    /**
     * @param mixed $dosen_status
     * @return MDosen
     */
    public function setDosenStatus($dosen_status)
    {
        $this->dosen_status = $dosen_status;
        return $this;
    }

    public function hasDosenStatus()
    {
        return !Helpers::_empty($this->dosen_status);
    }

    /**
     * @return mixed
     */
    public function getProdiId()
    {
        return $this->prodi_id;
    }

    /**
     * @param mixed $prodi_id
     * @return MDosen
     */
    public function setProdiId($prodi_id)
    {
        $this->prodi_id = $prodi_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProdiNama()
    {
        return $this->_prodi_nama;
    }

    /**
     * @return mixed
     */
    public function getPembimbing()
    {
        return $this->_pembimbing;
    }

    /**
     * @return mixed
     */
    public function getPembimbingBerlangsung()
    {
        return $this->_pembimbing_berlangsung;
    }

    /**
     * @return mixed
     */
    public function getPembimbingSelesai()
    {
        return $this->_pembimbing_selesai;
    }

}