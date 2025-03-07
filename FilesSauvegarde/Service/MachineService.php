<?php
include 'cnx.php';
include "dao.php";
class MachineService implements dao{
    private $db;
    function __construct()
    {
        $c = new connexion();
        $this-> db = $c->getdb();
    }
    function Inscription($cin,$nom,$login,$password)
    {
        $st = $this->db->prepare("insert into user(cin,nomComplet,login,password) values (?,?,?,?)");
        if($st->execute(array($cin,$nom,$login,$password))){
            return true;
        }else{
            return false;
        }
    }
    function login($login,$password)
    {

        $st = $this->db->prepare("Select * from user WHERE login='$login' and password='$password' ");
        $st->execute();

        if($st->rowCount() > 0){
            $row= $st->fetch();

            return $row;
        }
        else{
            return false;
        }

    }

    function add($machine)
    {
        $st = $this->db->prepare("insert into machine(Ref_Machine,Nom_Machine,image) values(?,?,?)");
        if($st->execute(array($machine->getRefmachine(), $machine->getNommachine(), $machine->getImage()))){
            return true;
        }else{
            return false;
        }
    }
    function addmachinecsv($machine)
    {
        $st = $this->db->prepare("insert into machine(Nom_Machine) values(?)");
        if($st->execute([$machine])){
            return true;
        }else{
            return false;
        }
    }
    function addarticle($article,$image)
    {
        $st = $this->db->prepare("insert into article(nom,image) values(?,?)");
        if($st->execute(array($article,$image))){
            return true;
        }else{
            return false;
        }
    }
    function findallarticle()
    {
        $req =$this->db->prepare("select * from article");
        if($req->execute()){
            return $req ->fetchAll();
        }
        else{
            return false;
        }
    }
    function add1($id,$src,$ida,$date,$cycle,$poid)
    {
        $st = $this->db->prepare("insert into files(idmachine,Chemin,idarticle,date,poids,cycle) values(?,?,?,?,?,?)");
        if($st->execute(array($id,$src,$ida,$date,$cycle,$poid))){
            return true;
        }else{
            return false;
        }
    }
    function update($o)
    {
        // TODO: Implement update() method.
    }
    function updatearticle($id,$nom,$image){

        try{
            $st = $this->db->prepare('UPDATE article 
                        SET nom = ?,image=? WHERE id = ?');
            $st->execute(array(
                $nom,$image,$id
            ));
            if($st->rowCount() > 0){
                return true;
            }
            return false;
        }
        catch(PDOException $e){
            echo "Error :" .$e->getMessage();;
        }
    }
    function updatemachine($id,$ref,$nom,$image){

        try{
            $st = $this->db->prepare('UPDATE machine 
                        SET Ref_Machine = ?,Nom_Machine=?,image=? WHERE id = ?');
            $st->execute(array(
                $ref,$nom,$image,$id
            ));
            if($st->rowCount() > 0){
                return true;
            }
            return false;
        }
        catch(PDOException $e){
            echo "Error :" .$e->getMessage();;
        }
    }

    function deletefile($id){
        try{
            $st = $this->db->prepare('delete from files where id =?');
            $st->execute(array($id));
            if($st->rowCount() > 0){
                return true;
            }
            return false;

        }
        catch(PDOException $e){
            echo "Error :" .$e->getMessage();;
        }
    }
    function delete($Id)
    {
        try{
            $st = $this->db->prepare('delete from machine where id =?');
            $st->execute(array($Id));
            if($st->rowCount() > 0){
                return true;
            }
            return false;

        }
        catch(PDOException $e){
            echo "Error :" .$e->getMessage();;
        }
    }
    function deletearticle($Id)
    {
        try{
            $st = $this->db->prepare('delete from article where id =?');
            $st->execute(array($Id));
            if($st->rowCount() > 0){
                return true;
            }
            return false;

        }
        catch(PDOException $e){
            echo "Error :" .$e->getMessage();;
        }
    }

    function findbyid($id)
    {
        // TODO: Implement findbyid() method.
        try {
            $st = $this->db->prepare("SELECT * FROM machine WHERE id = ?");
            $st->execute([$id]);
            $row = $st->fetch();
            if($row != null) {

                return $row;
            }
            return null;
        }
        catch(PDOException $e) {
            echo 'Error :' .$e->getMessage();
        }
    }
    function findbyidwherenomlike($id)
    {
        // TODO: Implement findbyid() method.
        try {
            $st = $this->db->prepare("SELECT * FROM machine WHERE LOWER(Nom_Machine) LIKE(?)");
            $st->execute([$id]);
            $row = $st->fetchAll();
            if($row != null) {

                return $row;
            }
            return null;
        }
        catch(PDOException $e) {
            echo 'Error :' .$e->getMessage();
        }
    }
    function findbyidwherenomlikearticle($id)
    {
        // TODO: Implement findbyid() method.
        try {
            $st = $this->db->prepare("SELECT * FROM article WHERE LOWER(nom) LIKE(?)");
            $st->execute([$id]);
            $row = $st->fetchAll();
            if($row != null) {

                return $row;
            }
            return null;
        }
        catch(PDOException $e) {
            echo 'Error :' .$e->getMessage();
        }
    }
    function findarticlebyid($id)
    {
        // TODO: Implement findbyid() method.
        try {
            $st = $this->db->prepare("SELECT * FROM article WHERE id = ?");
            $st->execute([$id]);
            $row = $st->fetch();
            if($row != null) {

                return $row;
            }
            return null;
        }
        catch(PDOException $e) {
            echo 'Error :' .$e->getMessage();
        }
    }
    function checkfile($id)
    {
        // TODO: Implement findbyid() method.
        try {
            $st = $this->db->prepare("SELECT * FROM files WHERE Chemin = ?");
            $st->execute([$id]);
            $row = $st->fetch();
            if($row != null) {

                return true;
            }
            return false;
        }
        catch(PDOException $e) {
            echo 'Error :' .$e->getMessage();
        }
    }
    function findallclause($id)
    {
        $req =$this->db->prepare("select * from files where idmachine = ? ");
        if($req->execute([$id])){
            return $req ->fetchAll();
        }
        else{
            return false;
        }
    }
    function findall()
    {
        $req =$this->db->prepare("select * from machine");
        if($req->execute()){
            return $req ->fetchAll();
        }
        else{
            return false;
        }
    }
    function selectcountscann()
    {
        $req =$this->db->prepare("select * from files");
        if($req->execute()){
            return $req->rowCount();
        }
        else{
            return false;
        }
    }
    function findcountproduit()
    {
        $req =$this->db->prepare("select * from machine");
        if($req->execute()){
            return $req->rowCount();
        }
        else{
            return false;
        }
    }
    function findcountproduitfiltrage($id)
    {
        $req =$this->db->prepare("select * from machine WHERE LOWER(Nom_Machine) LIKE(?)");
        if($req->execute([$id])){
            return $req->rowCount();
        }
        else{
            return false;
        }
    }
    function findcountmachinearitcle($idmachine)
    {
        $req =$this->db->prepare("select * from files where idmachine = ?");
        if($req->execute([$idmachine])){
            return $req->rowCount();
        }
        else{
            return false;
        }
    }
    function findcountarticle()
    {
        $req =$this->db->prepare("select * from article");
        if($req->execute()){
            return $req->rowCount();
        }
        else{
            return false;
        }
    }
    function findcountfiles($id)
    {
        $req =$this->db->prepare("select * from files where idmachine = ?");
        if($req->execute([$id])){
            return $req->rowCount();
        }
        else{
            return false;
        }
    }
    function findcountfilesarticle($id,$ida)
    {
        $req =$this->db->prepare("select * from files where idmachine = ? and idarticle = ?");
        if($req->execute(array($id,$ida))){
            return $req->rowCount();
        }
        else{
            return false;
        }
    }
    function findallarticlepagination($premier,$parPage,$id,$ida)
    {
        $sql = 'SELECT * FROM `files` where idmachine=:id and idarticle=:id1 ORDER BY `id` DESC LIMIT :premier, :parpage;';
        $query = $this->db->prepare($sql);
        $query->bindValue(':premier', $premier, PDO::PARAM_INT);
        $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':id1', $ida, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function findallmachinepagination($premier,$parPage,$id)
    {
        $sql = 'SELECT * FROM `files` where idmachine=:id ORDER BY `id` DESC LIMIT :premier, :parpage;';
        $query = $this->db->prepare($sql);
        $query->bindValue(':premier', $premier, PDO::PARAM_INT);
        $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function findallproduitpagination($premier,$parPage)
    {
        $sql = 'SELECT * FROM `machine` ORDER BY `id` DESC LIMIT :premier, :parpage;';
        $query = $this->db->prepare($sql);
        $query->bindValue(':premier', $premier, PDO::PARAM_INT);
        $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function findallproduitpaginationfiltrage($like)
    {
        $sql = 'SELECT * FROM `machine`  WHERE LOWER(Nom_Machine) LIKE(:hey) ORDER BY `id` DESC';
        $query = $this->db->prepare($sql);

        $query->bindValue(':hey', $like, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function findallarticlepagination1($premier,$parPage)
    {
        $sql = 'SELECT * FROM `article` ORDER BY `id` DESC LIMIT :premier, :parpage;';
        $query = $this->db->prepare($sql);
        $query->bindValue(':premier', $premier, PDO::PARAM_INT);
        $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>