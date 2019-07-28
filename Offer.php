<?php
//trebuie sa creez baza de date in workbench si sa fac chestia cu migratia
//trebuie sa creez obiectul oferta si sa o persist in baza de date dupa modelul user cu em
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM; 
// o sa adaugam pe offer ca este o etiate pt ca altfel doctrine nu are de unde sa stie ca offer e o entitate pe care sa o persiste in baza de data, deci folosim o annotare
/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */

class Offer {
    /**
     *
     * @var int 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    // ofertele vor fi puse in baza de bade deci vor avea nevoie de un id
    // ca sa definim cum mappam anumite prop la baza de date folosim niste annotari
    private $offerId;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $userId; //fiecare utilizaator are obiectul oferta al lui
                     // ca sa stim al carui user e acea oferta
    
     /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    private $customerName;
    /**
     * @ORM\Column(type="string", length=250)
     * @var string
     */
    private $offerDescription;
    
    /**
     * @ORM\Column(type="float")
     * @var float
     */
    
    private $price;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $avalability;
    /**
     * @ORM\Column(type="string", length=250)
     * @var string
     */
    private $comments; 
    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $done;
    // ca sa cream obiectul oferta avem nevoie de un constructor 
    // id-ul va fi autogenerat deci nu vom stii de la inceput id-ul decat in momentul in care va fi pus in baza de date
    // done nu va fi pus ca parametru pentru ca nu are sens sa avem o oferta care sa fie deja facuta(true)
    // comments trebuie sa fie completat ulterior de salesAcconut = change (obiectul-oferta))- ca si metoda
    // cand creen oferta, acea oferta va apartine unui user
    /**
     * @param string $offerDescription
     * @param string $customerName
     * @param float $price
     * @param string $avalability
     * @param string $comments
     * @param boolean $done
     */
    function __construct(int $userId, string $offerDescription, string $customerName, float $price, string $avalability, string $comments, bool $done) {
        $this->userId = $userId; // 1.initializare; fiecare oferta trebuie sa apartina unui utilizator
        $this->customerName = $customerName;//1.initializare; dat de offerMaker
        $this->offerDescription = $offerDescription;//1.initializare; dat de offerMaker
        $this->price = $price;//1.initializare; dat de ofertant
        $this->avalability = $avalability;//1.initializare; dat de offerMaker
        $this->comments = '';//1.initializare; dat de offerMaker dar modifica salesAccount = change (obiectul-oferta))- ca si metoda
        $this->done = false;
        
   //avem nevoie de niste getteri pt ca aceste proprietati sunt private si pt ca in momentul in care vrem sa afisem oferta vrem sa luam spre exemplu numele(el fiind privat nu avem acces la el) avem nevoie de niste metode care sa ne dea acces la acele proprietat = getteri
   //proprietatile nu le facem publice pt ca oricine ar avea cces la ele si ar putea sa le modifice gresit asta e INCAPSULARE ascunderea unor prop care nu vrem sa fie modificate din exterior       
    }
    
   // ce putem schimba la o Offerta(ca si offerMaker - offerMaker= add(obiectul-oferta))- ca si metoda: 
    function getOfferId() { //offerMaker
        return $this->offerId;
    }
    function getCustomerName(){ //edit pt offerMaker
        return $this->customerName;
    }
    function getOfferDescription() { //edit pt offerMaker
        return $this->offerDescription;
    }

    function getPrice() {
        return $this->price;
    }
    function getAvalability() {
        return $this->avalability;
   }
   function getUserId() {
       return $this->userId;
   }

   function getDone() {
       return $this->done;
   }

   function setUserId($userId) {
       $this->userId = $userId;
   }

   function setDone($done) {
       $this->done = $done;
   }

       public function setOfferDescription(string $description): self
    {
        $this->offerDescription = $description;

        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
    public function setComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;

    }
    function getComments() {
        return $this->comments;
    }
    function setOfferId($offerId) {
        $this->offerId = $offerId;
    }

    function setCustomerName($customerName) {
        $this->customerName = $customerName;
    }

    function setAvalability($avalability) {
        $this->avalability = $avalability;
    }


}