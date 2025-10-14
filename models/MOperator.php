<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class MOperator implements Template
{
    private $operator_id;
    private $operator_nama;
    private $operator_jenis;
    private $operator_username;
    private $operator_password;
    private $operator_metas;
    private $operator_status;

    public function _id()
    {
        return $this->operator_id;
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
        return Helpers::_empty($this->operator_id);
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
     * @return MOperator
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
        return $this->operator_nama;
    }

    /**
     * @param mixed $operator_nama
     * @return MOperator
     */
    public function setOperatorNama($operator_nama)
    {
        $this->operator_nama = $operator_nama;
        return $this;
    }

    /**
     * @param bool $explode
     * @return mixed
     */
    public function getOperatorJenis($explode = false)
    {
        return $explode ? explode(':', $this->operator_jenis) : $this->operator_jenis;
    }

    /**
     * @param mixed $operator_jenis
     * @return MOperator
     */
    public function setOperatorJenis($operator_jenis)
    {
        $this->operator_jenis = $operator_jenis;
        return $this;
    }

    /**
     * @return $this
     */
    public function parseOperatorJenis()
    {
        $this->setOperatorJenis(implode(':', $this->operator_jenis));
        return $this;
    }

    public function hasOperatorJenis($operator_jenis)
    {
        return strpos($this->operator_jenis, $operator_jenis) !== false;
    }

    /**
     * @return bool
     */
    public function hasOperatorJenisOperatorProdi()
    {
        return $this->hasOperatorJenis(Helpers::dir_operator_prodi);
    }

    /**
     * @return mixed
     */
    public function getOperatorUsername()
    {
        return $this->operator_username;
    }

    /**
     * @param mixed $operator_username
     * @return MOperator
     */
    public function setOperatorUsername($operator_username)
    {
        $this->operator_username = $operator_username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperatorPassword()
    {
        return $this->operator_password;
    }

    /**
     * @param mixed $operator_password
     * @return MOperator
     */
    public function setOperatorPassword($operator_password)
    {
        $this->operator_password = $operator_password;
        return $this;
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function getOperatorMetas($format = 'json')
    {
        return $format == 'array' ? json_decode($this->operator_metas, true) : $this->operator_metas;
    }

    /**
     * @param mixed $operator_metas
     * @param bool $encode
     * @return MOperator
     */
    public function setOperatorMetas($operator_metas, $encode = true)
    {
        $this->operator_metas = $encode ? json_encode($operator_metas) : $operator_metas;
        return $this;
    }

    public function addOperatorMeta($key, $value)
    {
        $_tmp = $this->getOperatorMetas('array');
        $_tmp[$key] = $value;
        $this->setOperatorMetas($_tmp);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperatorStatus()
    {
        return $this->operator_status;
    }

    /**
     * @param mixed $operator_status
     * @return MOperator
     */
    public function setOperatorStatus($operator_status)
    {
        $this->operator_status = $operator_status;
        return $this;
    }
}