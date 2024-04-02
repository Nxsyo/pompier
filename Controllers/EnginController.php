<?php

namespace Controllers ;
use PDO;
use Engin;

class EnginController extends Controller{

    public function panelengin($params) {
        $entityManager = $params["em"];
        $enginRepository = $entityManager->getRepository('Engin');
        $engins = $enginRepository->findAll();

        if ($this->isLoggedIn()) {
            echo $this->twig->render('crudEngin.html', ['engins' => $engins, 'params' => $params]); 
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function engindata($params) {
        $entityManager = $params["em"];
        $enginRepository = $entityManager->getRepository('Engin');
        $engins = $enginRepository->findAll();
        
        $result = array();
        foreach ($engins as $engin) {
            $engindata = array(
                "full_nom" => $engin->getFullNom(),
                "abr_nom" => $engin->getAbrNom(),
                "description" =>$engin->getDescription(),
                "photoLink" => $engin->getPhotoLink()
            );
            array_push($result, $engindata);
        }
        echo json_encode($result);
    }


    public function createEngin() {
        if ($this->isLoggedIn()) {
            echo $this->twig->render('createEngin.html');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function insert($params) {
        $em=$params['em'];

        $nom=($_POST['full_nom']);
        $abrnom=($_POST['abr_nom']);
        $description=($_POST['description']);
        $photoLink=file_get_contents($_FILES['photoLink']['tmp_name']);

        $newEngin = new Engin();
        $newEngin->setFullNom($nom);
        $newEngin->setAbrNom($abrnom);
        $newEngin->setDescription($description);
        $newEngin->setPhotoLink($photoLink);

        $em->persist($newEngin);
        $em->flush();

        header('Location: start.php?c=engin&t=panelengin');
    }

    public function editEngin($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $engin=$em->find('Engin',$id);

        if ($this->isLoggedIn()) {
            echo $this->twig->render('editEngin.html',['engin'=>$engin]);
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function updateEngin($params) {
        $em = $params['em'];
        $id = $params['post']['id'];
        $engin = $em->find('Engin', $id);
    
        $engin->setFullNom($params['post']['nom_engin']);
        $engin->setAbrNom($params['post']['nom_abr']);
        $engin->setDescription($params['post']['description']);
    
        if (!empty($_FILES['nouvellePhoto']['tmp_name'])) {
            $photoLink = file_get_contents($_FILES['nouvellePhoto']['tmp_name']);
            $engin->setPhotoLink($photoLink);
        }
    
        $em->flush();
    
        header('Location: start.php?c=engin&t=panelengin');
        exit();
    }
    

    public function deleteEngin($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $engin=$em->find('Engin',$id);

        $em->remove($engin);
        $em->flush();

        if ($this->isLoggedIn()) {
            header('Location: start.php?c=engin&t=panelengin');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }
    

}
?>