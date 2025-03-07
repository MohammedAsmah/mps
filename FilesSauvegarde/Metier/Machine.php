<?php

Class Machine{
    private $id,$refmachine,$nommachine,$source,$image,$idarticle;

    public function construct($id,$refmachine,$nommachine,$source){
        $machine = new Machine();
        $machine->setId($id);
        $machine->setRefmachine($refmachine);
        $machine->setNommachine($nommachine);
        $machine->setSource($source);
        return $machine;
    }
    public function construct1($refmachine,$nommachine,$image){
        $machine = new Machine();
        $machine->setRefmachine($refmachine);
        $machine->setNommachine($nommachine);
        $machine->setImage($image);
        return $machine;
    }

    /**
     * @return mixed
     */
    public function getIdarticle()
    {
        return $this->idarticle;
    }

    /**
     * @param mixed $idarticle
     */
    public function setIdarticle($idarticle)
    {
        $this->idarticle = $idarticle;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRefmachine()
    {
        return $this->refmachine;
    }

    /**
     * @param mixed $refmachine
     */
    public function setRefmachine($refmachine)
    {
        $this->refmachine = $refmachine;
    }

    /**
     * @return mixed
     */
    public function getNommachine()
    {
        return $this->nommachine;
    }

    /**
     * @param mixed $nommachine
     */
    public function setNommachine($nommachine)
    {
        $this->nommachine = $nommachine;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

}
?>
