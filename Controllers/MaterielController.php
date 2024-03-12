<?php

namespace Controllers ;
use PDO;
use Materiel;
use Engin;

class MaterielController extends Controller{
    public function panelmateriel($params) {
        
        $entityManager = $params["em"];
        $enginRepository = $entityManager->getRepository('Materiel');
        $materiels = $enginRepository->findAll();

        if ($this->isLoggedIn()) {
            echo $this->twig->render('crudMateriel.html', ['materiels' => $materiels, 'params' => $params]); 
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function createMateriel($params) {
        $entityManager = $params["em"];
        $engins = $entityManager->getRepository(Engin::class)->findAll();
        
        if ($this->isLoggedIn()) {
            echo $this->twig->render('createMateriel.html', ['engins'=>$engins]);
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function insert($params) {
        $em=$params['em'];

        $nom=($_POST['nom']);
        $photoLink=file_get_contents($_FILES['photoLink']['tmp_name']);
        $desc=($_POST['description']);
        $engin_id = ($_POST['engin']);
        $engin = $em->getRepository(Engin::class)->find($engin_id);

        $newMateriel = new Materiel();
        $newMateriel->setNom($nom);
        $newMateriel->setPhotoLink($photoLink);
        $newMateriel->setDescription($desc);
        $newMateriel->setEngin($engin);

        $em->persist($newMateriel);
        $em->flush();

        header('Location: start.php?c=materiel&t=panelmateriel');
    }

    public function deleteMateriel($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $materiel=$em->find('Materiel',$id);

        $em->remove($materiel);
        $em->flush();

        header('Location: start.php?c=materiel&t=panelmateriel');
    }

    public function editMateriel($params) {
        $entityManager = $params["em"];
        $engins = $entityManager->getRepository(Engin::class)->findAll();

        $id=($params['get']['id']);
        $em=$params['em'];
        $materiel=$em->find('Materiel',$id);

        if ($this->isLoggedIn()) {
            echo $this->twig->render('editMateriel.html',['materiel'=>$materiel , 'engins'=>$engins]);
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function updateMateriel($params) {
        $em = $params['em'];
        $id = $params['post']['id'];
        $materiel = $em->find('Materiel', $id);
    
        $materiel->setNom($params['post']['nom']);
        $materiel->setDescription($params['post']['description']);

        if (!empty($_FILES['nouvellePhoto']['tmp_name'])) {
            $photoLink = file_get_contents($_FILES['nouvellePhoto']['tmp_name']);
            $materiel->setPhotoLink($photoLink);
        }
    
        $enginId = $params['post']['engin'];
        $engin = $em->find('Engin', $enginId);

        $materiel->setEngin($engin);

        $em->flush();
    
        header('Location: start.php?c=materiel&t=panelmateriel');
        exit();
    }
    
}