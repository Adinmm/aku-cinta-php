<?php
class MLogbook
{
    private $id;
    private $tanggal;
    private $jkem;
    private $uraian;
    private $target;
    private $foto; 
    private $mahasiswa_nim;

    public function _id() {
        return $this->id;
    }

    public function _init($data) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
        return $this;
    }

    public function _toArray() {
        return get_object_vars($this);
    }

    // Getter & Setter
    public function getId() { return $this->id; }
    public function setId($v) { $this->id = $v; return $this; }

    public function getTanggal() { return $this->tanggal; }
    public function setTanggal($v) { $this->tanggal = $v; return $this; }

    public function getJkem() { return $this->jkem; }
    public function setJkem($v) { $this->jkem = $v; return $this; }

    public function getUraian() { return $this->uraian; }
    public function setUraian($v) { $this->uraian = $v; return $this; }

    public function getTarget() { return $this->target; }
    public function setTarget($v) { $this->target = $v; return $this; }

    public function getFoto() { return $this->foto; }
    public function setFoto($v) { $this->foto = $v; return $this; }

    public function getNim() { return $this->nim; }
    public function setNim($v) { $this->nim = $v; return $this; }
}
