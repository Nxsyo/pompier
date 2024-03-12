<?php

namespace Controllers;

use PDO;
use Personnel;

class PersonnelController extends Controller
{
    public function panelpersonnel($params) {
        $entityManager = $params["em"];
        $personnelRepository = $entityManager->getRepository('Personnel');
        $personnels = $personnelRepository->findAll();

        if ($this->isLoggedIn()) {
            echo $this->twig->render('crudPersonnel.html', ['personnels' => $personnels, 'params' => $params]); 
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function createPersonnel() {
        if ($this->isLoggedIn()) {
            echo $this->twig->render('createPersonnel.html');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function insert($params) {
        $em=$params['em'];

        $nom=($_POST['nom']);
        $prenom=($_POST['prenom']);
        $grade=($_POST['grade']);
        $photo=file_get_contents($_FILES['photo']['tmp_name']);
        $fonction=($_POST['fonction']);
        $role=($_POST['role']);

        $newPersonnel = new Personnel();
        $newPersonnel->setNom($nom);
        $newPersonnel->setPrenom($prenom);
        $newPersonnel->setGrade($grade);
        $newPersonnel->setPhoto($photo);
        $newPersonnel->setFonction($fonction);
        $newPersonnel->setRole($role);


        $em->persist($newPersonnel);
        $em->flush();

        header('Location: start.php?c=personnel&t=panelpersonnel');
    }

    public function editPersonnel($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $personnel=$em->find('Personnel',$id);

        if ($this->isLoggedIn()) {
            echo $this->twig->render('editPersonnel.html',['personnel'=>$personnel]);
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function updatePersonnel($params) {

        $em = $params['em'];
        $id =($params['post']['id']);
    
        $personnel = $em->find('Personnel', $id);
    
        $personnel->setNom($params['post']['nom']);
        $personnel->setPrenom($params['post']['prenom']);
        $personnel->setGrade($params['post']['grade']);
        $personnel->setFonction($params['post']['fonction']);
        $personnel->setRole($params['post']['role']);

        if (!empty($_FILES['nouvellePhoto']['tmp_name'])) {
            $photo = file_get_contents($_FILES['nouvellePhoto']['tmp_name']);
            $personnel->setPhoto($photo);
        }
    
        
            $em->flush();
        
            header('Location: start.php?c=personnel&t=panelpersonnel');
            exit();

    }

    public function deletePersonnel($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $personnel=$em->find('Personnel',$id);

        $em->remove($personnel);
        $em->flush();

        if ($this->isLoggedIn()) {
            header('Location: start.php?c=personnel&t=panelpersonnel');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }
}