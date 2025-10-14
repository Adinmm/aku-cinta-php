<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MMahasiswa implements Template
{
    private $mahasiswa_nim;
    private $mahasiswa_nama;
    private $mahasiswa_nomor_hp;
    private $mahasiswa_email;
    private $mahasiswa_kuliah;
    private $mahasiswa_foto;
    private $dosen_pa_kode;
    private $prodi_id;

    private $_dosen_pa_nama;
    private $_dosen_pa_nip;
    private $_dosen_pa_email;
    private $_prodi_nama;

    public function _id()
    {
        return $this->mahasiswa_nim;
    }

    public function _init($request)
    {
        foreach ($request as $field => $value)
            !array_key_exists($field, $this->_toArray())
            || $this->{'set' . Helpers::_camel_case($field, '_', '')}($request[$field]);

        return $this;
    }

    public function _toArray($type = Helpers::type_attribute_all, $exclude = array())
    {
        return Helpers::_to_array(get_object_vars($this), $type, $exclude);
    }

    public function _empty()
    {
        return Helpers::_empty($this->mahasiswa_nim);
    }

    public function _filter()
    {
        !Helpers::_empty($this->prodi_id) || $this->prodi_id = 0;
        return $this;
    }

    public function _init_SIA($mahasiswa_nim = '')
    {
        $mahasiswa_nim || $mahasiswa_nim = $this->mahasiswa_nim;
        $arr_mahasiswa = CMahasiswa::_gi()->_get_sia($mahasiswa_nim);
        return $this
            ->setMahasiswaNama(Helpers::_arr($arr_mahasiswa, 'nama'))
            ->setMahasiswaNomorHp(Helpers::_arr($arr_mahasiswa, 'no_hp'))
            ->setMahasiswaEmail(Helpers::_arr($arr_mahasiswa, 'email'))
            ->setMahasiswaKuliah(CMahasiswa::$_kuliah[Helpers::_arr($arr_mahasiswa, 'status_kuliah')])
            ->setMahasiswaFoto(Helpers::_arr($arr_mahasiswa, 'foto'))
            ->setDosenPaKode(Helpers::_arr($arr_mahasiswa, 'kode_dosen_pa'))
            ->setProdiId(Helpers::_arr($arr_mahasiswa, 'kode_prodi'));
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
     * @return MMahasiswa
     */
    public function setMahasiswaNim($mahasiswa_nim)
    {
        $this->mahasiswa_nim = $mahasiswa_nim;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMahasiswaNama()
    {
        return $this->mahasiswa_nama;
    }

    /**
     * @param mixed $mahasiswa_nama
     * @return MMahasiswa
     */
    public function setMahasiswaNama($mahasiswa_nama)
    {
        $this->mahasiswa_nama = $mahasiswa_nama;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMahasiswaNomorHp()
    {
        return $this->mahasiswa_nomor_hp;
    }

    /**
     * @param mixed $mahasiswa_nomor_hp
     * @return MMahasiswa
     */
    public function setMahasiswaNomorHp($mahasiswa_nomor_hp)
    {
        $this->mahasiswa_nomor_hp = $mahasiswa_nomor_hp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMahasiswaEmail()
    {
        return $this->mahasiswa_email;
    }

    /**
     * @param mixed $mahasiswa_email
     * @return MMahasiswa
     */
    public function setMahasiswaEmail($mahasiswa_email)
    {
        $this->mahasiswa_email = $mahasiswa_email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMahasiswaKuliah()
    {
        return $this->mahasiswa_kuliah;
    }

    /**
     * @param mixed $mahasiswa_kuliah
     * @return MMahasiswa
     */
    public function setMahasiswaKuliah($mahasiswa_kuliah)
    {
        $this->mahasiswa_kuliah = $mahasiswa_kuliah;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasMahasiswaKuliah()
    {
        return !Helpers::_empty($this->mahasiswa_kuliah);
    }

    /**
     * @return bool
     */
    public function isMahasiswaKuliahAktif()
    {
        return $this->mahasiswa_kuliah == CMahasiswa::$_kuliah_text[CMahasiswa::_kuliah_aktif];
    }

    /**
     * @return mixed
     */
    public function getMahasiswaFoto()
    {
        return $this->mahasiswa_foto;
    }

    /**
     * @param mixed $mahasiswa_foto
     * @return MMahasiswa
     */
    public function setMahasiswaFoto($mahasiswa_foto)
    {
        $this->mahasiswa_foto = $mahasiswa_foto;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasMahasiswaFoto()
    {
        return !Helpers::_empty($this->mahasiswa_foto);
    }

    public function getMahasiswaFoto2($width = 300, $height = 300)
    {
        return $this->hasMahasiswaFoto()
            ? sprintf('%s/index.php/foto/mahasiswa/%s/%s/%s/%s',
                SIA_URI, $this->mahasiswa_nim, $width, $height, md5(time())) :
            sprintf('%s/logo.png', URI_IMG_PATH);
    }

    /**
     * @return mixed
     */
    public function getDosenPaKode()
    {
        return $this->dosen_pa_kode;
    }

    /**
     * @param mixed $dosen_pa_kode
     * @return MMahasiswa
     */
    public function setDosenPaKode($dosen_pa_kode)
    {
        $this->dosen_pa_kode = $dosen_pa_kode;
        return $this;
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
     * @return MMahasiswa
     */
    public function setProdiId($prodi_id)
    {
        $this->prodi_id = $prodi_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDosenPaNama()
    {
        return $this->_dosen_pa_nama;
    }

    /**
     * @return mixed
     */
    public function getDosenPaNip()
    {
        return $this->_dosen_pa_nip;
    }

    /**
     * @return mixed
     */
    public function getDosenPaEmail()
    {
        return $this->_dosen_pa_email;
    }

    /**
     * @return mixed
     */
    public function getProdiNama()
    {
        return $this->_prodi_nama;
    }

}