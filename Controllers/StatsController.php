<?php

namespace Controllers ;
use PDO;
use Stats;

class StatsController extends Controller{

    public function panelstats($params) {
        $entityManager = $params["em"];
        $statsRepository = $entityManager->getRepository('Stats');
        $stats = $statsRepository->findAll();

        if ($this->isLoggedIn()) {
            echo $this->twig->render('crudStats.html', ['stats' => $stats, 'params' => $params]); 
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function statsdata($params) {
        $entityManager = $params["em"];
        $statsRepository = $entityManager->getRepository('Stats');
        $stats = $statsRepository->findAll();
        
        $result = array();
        foreach ($stats as $stat) {
            $statsdata = array(
                "titre" => $stat->getTitre(),
                "chiffre" => $stat->getchiffre(),
                "short_desc" => $stat->getShortDesc(),
                "long_desc" => $stat->getLongDesc(),
                "icon" => $stat->getIcon(),
            );
            array_push($result, $statsdata);
        }
        echo json_encode($result);
    }


    public function createStats() {
        if ($this->isLoggedIn()) {
            echo $this->twig->render('createStats.html');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function insert($params) {
        $em=$params['em'];

        $titre=($_POST['titre']);
        $chiffre=($_POST['chiffre']);
        $shortdesc=($_POST['short_desc']);
        $longdesc=($_POST['long_desc']);
        $icon=($_POST['icon']);

        $newStats = new Stats();
        $newStats->setTitre($titre);
        $newStats->setChiffre($chiffre);
        $newStats->setShortDesc($shortdesc);
        $newStats->setLongDesc($longdesc);
        $newStats->setIcon($icon);

        $em->persist($newStats);
        $em->flush();

        header('Location: start.php?c=stats&t=panelstats');
    }

    public function editstats($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $stats=$em->find('Stats',$id);

        if ($this->isLoggedIn()) {
            echo $this->twig->render('editStats.html',['stats'=>$stats]);
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function updateStats($params) {
        $em = $params['em'];
        $id = $params['post']['id'];
        $stats = $em->find('Stats', $id);
    
        $stats->setTitre($params['post']['titre']);
        $stats->setChiffre($params['post']['chiffre']);
        $stats->setShortDesc($params['post']['short_desc']);
        $stats->setLongDesc($params['post']['long_desc']);
        $stats->setIcon($params['post']['icon']);

    
        $em->flush();
    
        header('Location: start.php?c=stats&t=panelstats');
        exit();
    }
    

    public function deleteStats($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $stats=$em->find('Stats',$id);

        $em->remove($stats);
        $em->flush();

        if ($this->isLoggedIn()) {
            header('Location: start.php?c=stats&t=panelstats');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }
    

}
?>