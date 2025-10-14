<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MStatus implements Template
{
    private $status_id;
    private $status_waktu;
    private $status_jenis;
    private $status_jenis_id;
    private $status_status;
    private $status_keterangan;
    private $status_tahun_akademik;
    private $operator_id = 0;

    private $_operator_nama;
    private $_dosen_nama;
    private $_mahasiswa_nama;

    public function _id()
    {
        return $this->status_id;
    }

    public function _init($request)
    {
        foreach ($request as $field => $value)
            !array_key_exists($field, $this->_toArray())
            || $this->{'set' . Helpers::_camel_case($field, '_', '')}($request[$field]);

        $this->status_tahun_akademik || $this->setStatusTahunAkademik(CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1')));

        return $this;
    }

    public function _toArray($type = Helpers::type_attribute_all, $exclude = array())
    {
        return Helpers::_to_array(get_object_vars($this), $type, $exclude);
    }

    public function _empty()
    {
        return Helpers::_empty($this->status_id);
    }

    /**
     * @return mixed
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @param mixed $status_id
     * @return MStatus
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;
        return $this;
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function getStatusWaktu($format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($this->status_waktu));
    }

    /**
     * @param mixed $status_waktu
     * @return MStatus
     */
    public function setStatusWaktu($status_waktu)
    {
        $this->status_waktu = $status_waktu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusJenis()
    {
        return $this->status_jenis;
    }

    /**
     * @param mixed $status_jenis
     * @return MStatus
     */
    public function setStatusJenis($status_jenis)
    {
        $this->status_jenis = $status_jenis;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusJenisId()
    {
        return $this->status_jenis_id;
    }

    /**
     * @param mixed $status_jenis_id
     * @return MStatus
     */
    public function setStatusJenisId($status_jenis_id)
    {
        $this->status_jenis_id = $status_jenis_id;
        return $this;
    }

    /**
     * @param int $type
     * @return mixed
     */
    public function getStatusStatus($type = 0)
    {
        switch ($type) {
            case CStatus::_status_type_label:
                return Helpers::_arr(CStatus::$_status_label, $this->status_status);
            case CStatus::_status_type_color:
                return Helpers::_arr(CStatus::$_status_color, $this->status_status);
            case CStatus::_status_type_icon:
                return Helpers::_arr(CStatus::$_status_icon, $this->status_status);
            default:
                return $this->status_status;
        }
    }

    /**
     * @param mixed $status_status
     * @return MStatus
     */
    public function setStatusStatus($status_status)
    {
        $this->status_status = $status_status;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStatusSuccess()
    {
        return $this->status_status == Helpers::verify_success;
    }

    /**
     * @return bool
     */
    public function isStatusWaiting()
    {
        return $this->status_status == Helpers::verify_waiting;
    }

    /**
     * @return bool
     */
    public function isStatusReject()
    {
        return $this->status_status == Helpers::verify_reject;
    }

    /**
     * @return mixed
     */
    public function getStatusKeterangan()
    {
        return $this->status_keterangan;
    }

    /**
     * @return mixed
     */
    public function getStatusTahunAkademik()
    {
        return $this->status_tahun_akademik;
    }

    /**
     * @param $status_tahun_akademik
     * @return $this
     */
    public function setStatusTahunAkademik($status_tahun_akademik)
    {
        $this->status_tahun_akademik = $status_tahun_akademik;
        return $this;
    }

    /**
     * @param mixed $status_keterangan
     * @return MStatus
     */
    public function setStatusKeterangan($status_keterangan)
    {
        $this->status_keterangan = $status_keterangan;
        return $this;
    }

    public function hasStatusKeterangan()
    {
        return !Helpers::_empty($this->status_keterangan);
    }

    /**
     * @return mixed
     */
    public function getOperatorId()
    {
        return $this->operator_id;
    }

    /**
     * @param mixed $operator_id
     * @return MStatus
     */
    public function setOperatorId($operator_id)
    {
        $this->operator_id = $operator_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperatorNama()
    {
        return $this->_operator_nama;
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
    public function getMahasiswaNama()
    {
        return $this->_mahasiswa_nama;
    }

    public function getNama()
    {
        $_tmp = '';
        !$this->_operator_nama || $_tmp = $this->_operator_nama;
        !$this->_dosen_nama || $_tmp = $this->_dosen_nama;
        !$this->_mahasiswa_nama || $_tmp = $this->_mahasiswa_nama;
        return $_tmp;
    }

}