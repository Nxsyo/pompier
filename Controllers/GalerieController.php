<?php

namespace Controllers ;
use PDO;
use Galerie;

class GalerieController extends Controller{
    
    public function panelgalerie($params) {
        $entityManager = $params["em"];
        $galerieRepository = $entityManager->getRepository('Galerie');
        $galeries = $galerieRepository->findAll();

        if ($this->isLoggedIn()) {
            echo $this->twig->render('crudGalerie.html', ['galeries' => $galeries, 'params' => $params]); 
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function createGalerie() {
        if ($this->isLoggedIn()) {
            echo $this->twig->render('createGalerie.html');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function insert($params) {
        $em=$params['em'];

        $titre=($_POST['titre']);
        $description=($_POST['description']);
        $photoLink=file_get_contents($_FILES['photoLink']['tmp_name']);

        $newGalerie = new Galerie();
        $newGalerie->setTitre($titre);
        $newGalerie->setDescription($description);
        $newGalerie->setPhotoLink($photoLink);

        $em->persist($newGalerie);
        $em->flush();

        header('Location: start.php?c=galerie&t=panelgalerie');
    }

    public function editGalerie($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $galerie=$em->find('Galerie',$id);

        if ($this->isLoggedIn()) {
            echo $this->twig->render('editGalerie.html',['galerie'=>$galerie]);
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function updateGalerie($params) {
        $em = $params['em'];
        $id = $params['post']['id'];
        $galerie = $em->find('Galerie', $id);
    
        $galerie->setTitre($params['post']['titre']);
        $galerie->setDescription($params['post']['description']);
    
        if (!empty($_FILES['nouvellePhoto']['tmp_name'])) {
            $photoLink = file_get_contents($_FILES['nouvellePhoto']['tmp_name']);
            $galerie->setPhotoLink($photoLink);
        }
    
        $em->flush();
    
        header('Location: start.php?c=galerie&t=panelgalerie');
        exit();
    }

    public function deleteGalerie($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $galerie=$em->find('Galerie',$id);

        $em->remove($galerie);
        $em->flush();

        if ($this->isLoggedIn()) {
            header('Location: start.php?c=galerie&t=panelgalerie');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function galeriedata($params) {
        $entityManager = $params["em"];
        $galerieRepository = $entityManager->getRepository('Galerie');
        $galeries = $galerieRepository->findAll();
        
        $result = array();
        foreach ($galeries as $galerie) {
            $galleryData = array(
                "titre" => $galerie->getTitre(),
                "description" => $galerie->getDescription(),
                "photoLink" => $galerie->getPhotoLink()
            );
            array_push($result, $galleryData);
        }
        echo json_encode($result);
    }
    
    
}

