<?php

namespace Checker\LBCCheckerBundle\Model;

use Symfony\Component\DomCrawler\Crawler;

class LeboncoinAdsCrawler {

  //url of the research
  private $researchUrl;
  //last date of search
  private $lastSearchDate;
  //domCrawler to Crawl the webpages
  private $crawler;
  //list of small ads
  private $smallAds = array();
  //Url of the nex page
  private $nextPageUrl;
  //numero de la page en cours d'utilisation
  private $currentPageNumber;
  //N° max de la page
  private $maxPageNumber;

  public function __construct($url, $lastDate = null, $maxPageNumber = 5) {

    $this->researchUrl = $url;
    $this->maxPageNumber = $maxPageNumber;
    $this->lastSearchDate = $lastDate;
    $this->lastSearchDate = new DateTime('2012-01-01'); //mktime(0, 0, 0, 3, 3, 2012);
    $this->setCrawler($this->researchUrl);
    $this->currentPageNumber = 1;
    $this->setNextPageUrlFromCrawler();
  }

  /*
   * Fonction qui va chercher dans la page en cours, l'url de la page suivante.
   */

  public function setNextPageUrlFromCrawler() {

    $linkText = trim($this->crawler->filter('#paging .page a')->last()->text());

    if ($linkText == 'Page suivante') {
      $this->nextPageUrl = $this->crawler->filter('#paging .page a')->last()->attr('href');
      var_dump($this->nextPageUrl);
    } else {
      $this->nextPageUrl = 'no next page';
    }
  }

  public function setCrawler($url) {
    $this->crawler = new Crawler();
    $this->crawler->addHtmlContent(file_get_contents($url), 'ISO-8859-15');
  }

  public function getSmallAdsOfTheCurrentPage() {
    $crawlerNode = new Crawler();
    $crawler = $this->crawler->filter('.list-ads > a');
    var_dump($crawler);
    foreach ($crawler as $node) {
      $crawlerNode->addNode($node);

      $result = trim(str_replace('\n', ' ', $crawlerNode->filter('div.date')->text()));
      $date = $this->convertDate($result);
      //si date inférieur à date de la dernière annonce de la dernière alerte
      //générée, on stoppe le traitement
      if ($date < $this->lastSearchDate) {
        break;
      } else {
        //pas trouvé mieux pour récupérer les éléments de l'annonce

        $urlImage = ($crawlerNode->filter('img')->count() > 0) ? trim($crawlerNode->filter('img')->attr('src')) : '';
        $lieu = explode('/', trim($crawlerNode->filter('.placement')->text()));
        if (count($lieu) > 1) {
          $ville = trim($lieu[0]);
          $departement = trim($lieu[1]);
        } else {
          $ville = '';
          $departement = trim($lieu[0]);
        }
        $prix = ($crawlerNode->filter('.price')->count() > 0) ? trim($crawlerNode->filter('.price')->text()) : '';
        $categorie = ($crawlerNode->filter('.category')->count() > 0) ? trim($crawlerNode->filter('.category')->text()) : '';
        $adToAdd = array(
            'date' => $date->format('d-m-Y - H:i'),
            'url' => trim($crawlerNode->filter('a')->first()->attr('href')),
            'titre' => trim($crawlerNode->filter('.title')->text()),
            'departement' => $departement,
            'categorie' => $categorie,
            'ville' => $ville,
            'prix' => $prix,
            'url_image' => $urlImage,
        );
      }
      $this->addSmallAd($adToAdd);
      $crawlerNode->clear();
    }
  }

  private function addSmallAd($ad) {
    $this->smallAds[] = $ad;
  }

  /*
   * Converti la date récupérée sur lbc en timestamp UNIX
   */

  private function convertDate($data) {

    //recuperation des infos sur la date 


    $result = explode(':', $data);
    $min = $result[1];
    $hour = substr($result[0], -2);
    $day = substr($result[0], 0, strlen($result[0]) - 2);
    $dateOfAd = new DateTime();
    $dateOfAd->setTime($hour, $min);
    if (strstr($data, 'Aujourd')) {
      //date du jour  rien a faire
    } elseif (strstr($data, 'Hier')) {
      //veille
      $interval = new DateInterval('P1D');
      $dateOfAd->sub($interval);
    } else {
      $yearNow = date('Y');
      $monthNow = date('n');
      $toStringMonth = array(
          'jan' => 1,
          'fév' => 2,
          'mars' => 3,
          'avril' => 4,
          'mai' => 5,
          'juin' => 6,
          'juil' => 7,
          'août' => 8,
          'sept' => 9,
          'oct' => 10,
          'nov' => 11,
          'déc' => 12
      );

      //autre jour
      $result = explode(' ', $day);

      $month = $toStringMonth[trim($result[1])];
      $dayOfMonth = $result[0];
//      $result = explode(' ', $data);
//      $month = $toStringMonth[$result[1]];
      //verification pour savoir si année n-1
      if ($monthNow - $month < 0) {
        $dateOfAd->setDate($yearNow - 1, $month, $dayOfMonth);
      } else {
        $dateOfAd->setDate($yearNow, $month, $dayOfMonth);
      }
    }
    return $dateOfAd;
  }

  /*
   * Méthode qui renvoi un tableau a les la liste des dernières annonces
   * 2 critère de récupération : date + nombre de pages à parcourir
   */

  public function getSmallAds() {
    return $this->smallAds;
  }

  public function setResearchUrl($url) {
    $this->researchUrl = $url;
  }

  public function goNextPage() {
    //$this->setResearchUrl($this->nextPageUrl);
    $this->setCrawler($this->nextPageUrl);
    //$this->setResearchUrl($this->setNextPageUrlFromCrawler());
  }

  public function getAllAds() {
    $i = 0;
    var_dump($this);
    while ($i < $this->maxPageNumber && $this->nextPageUrl != 'no next page') {
      $this->setNextPageUrlFromCrawler();
      $this->getSmallAdsOfTheCurrentPage();
      if ($this->nextPageUrl != 'no next page') {
        $this->goNextPage();
      }

      $i++;
    }
    return $this->getSmallAds();
  }

}

?>
