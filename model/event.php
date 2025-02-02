<?php
class Evenement
{
    private $id_evenement;
    private $titre;
    private $contenu;
    private $dateEvenement;
    private $heureEvenement;
    private $lieu;
    private $prix;
    private $nbPlaces;
    private $image;
    private $id_categorie;
    private $id_domaine;
    private $id_admin;
    
    public function __construct($id_evenement, $titre, $contenu, $dateEvenement, $lieu, $prix, $nbPlaces, $image, $heureEvenement, $id_categorie, $id_domaine , $id_admin)
    {
        $this->id_evenement = $id_evenement;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->dateEvenement = $dateEvenement;
        $this->lieu = $lieu;
        $this->prix = $prix;
        $this->nbPlaces = $nbPlaces;
        $this->image = $image;
        $this->heureEvenement = $heureEvenement;
        $this->id_categorie = $id_categorie;
        $this->id_domaine = $id_domaine;
        $this->id_admin = $id_admin;
    }

    public function getId_evenement()
    {
        return $this->id_evenement;
    }
    public function getId_auteur()
    {
        return $this->id_auteur;
    }
    public function getTitre()
    {
        return $this->titre;
    }
    public function getContenu()
    {
        return $this->contenu;
    }
    public function getDateEvenement()
    {
        return $this->dateEvenement;
    }
    public function getHeureEvenement()
    {
        return $this->heureEvenement;
    }
    public function getLieu()
    {
        return $this->lieu;
    }
    public function getPrix()
    {
        return $this->prix;
    }
    public function getNbPlaces()
    {
        return $this->nbPlaces;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setIdEvenement($id_evenement)
    {
        $this->id_evenement = $id_evenement;
    }
    public function setIdAuteur($id_auteur)
    {
        $this->id_auteur = $id_auteur;
    }
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }
   
    public function setDateEvenement($dateEvenement)
    {
        $this->dateEvenement = $dateEvenement;
    }
    public function setHeureEvenement($heureEvenement)
    {
        $this->heureEvenement = $heureEvenement;
    }
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
    public function setNbPlaces($nbPlaces)
    {
        $this->nbPlaces = $nbPlaces;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function getIdCategorie()
    {
        return $this->id_categorie;
    }
    public function setIdCategorie($id_categorie)
    {
        $this->id_categorie = $id_categorie;
    }
    public function getIdDomaine()
    {
        return $this->id_domaine;
    }
    public function setIdDomaine($id_domaine)
    {
        $this->id_domaine = $id_domaine;
    }
    public function getIdAdmin()
    {
        return $this->id_admin;
    }
    public function setIdAdmin($id_admin)
    {
        $this->id_admin = $id_admin;
    }
}
?>