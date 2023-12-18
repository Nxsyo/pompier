<?php

namespace Controllers;

use User;

class UserController extends Controller
{
    public function signin() //méthode qui renvoi sur la page d'inscription
    {
        echo $this->twig->render('signinpage.html');
    }

    public function login() {       //methode qui renvoi sur la page de connexion
        echo $this->twig->render('loginpage.html');
    }

    public function verifLogin($params) {     //methode qui verifie les parametres de connexion
        $em = $params['em'];

        $email = ($_POST['email']);
        $password = ($_POST['password']);

        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->andWhere('u.password = :password')
            ->setParameter('email', $email)
            ->setParameter('password', $password);

        $query = $qb->getQuery();
        $user = $query->getOneOrNullResult();

        if ($user) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_nom'] = $user->getNom();
            $_SESSION['user_prenom'] = $user->getPrenom();
            $_SESSION['user_email'] = $user->getEmail();

            header('Location: start.php?c=user&t=admindisplay');
        } else {
            echo $this->twig->render('loginpage.html',['error' => 'Identifiants invalides']);
        }

    }

    public function logout()    //methode qui permet de se deconnecter
    {
        session_destroy();
        header('Location: start.php?c=user&t=login');
        exit();
    }

    public function panelusers($params) {
        $entityManager = $params["em"];
        $enginRepository = $entityManager->getRepository('User');
        $users = $enginRepository->findAll();

        if ($this->isLoggedIn()) {
            echo $this->twig->render('crudusers.html', ['users' => $users, 'params' => $params]); 
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function createUser() {
        if ($this->isLoggedIn()) {
            echo $this->twig->render('createUser.html');
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }

    public function insert($params)
    {
        $em = $params['em'];

        $nom = ($_POST['nom']);
        $prenom = ($_POST['prenom']);
        $email = ($_POST['email']);
        $password = ($_POST['password']);

        $newUser = new User();

        $newUser->setNom($nom);
        $newUser->setPrenom($prenom);
        $newUser->setEmail($email);
        $newUser->setPassword($password);

        $em->persist($newUser);
        $em->flush();

        $_SESSION['user_id'] = $newUser->getId();
        $_SESSION['user_nom'] = $newUser->getNom(); 
        $_SESSION['user_prenom'] = $newUser->getPrenom(); 
        $_SESSION['user_email'] = $newUser->getEmail(); 


        header('Location: start.php?c=user&t=panelusers');
    }

    public function editUser($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $user=$em->find('User',$id);
        echo $this->twig->render('editUser.html',['user'=>$user]);
    }

    public function updateUser($params) {

        $em = $params['em'];
        $id =($params['post']['id']);
    
        $user = $em->find('User', $id);
    
        $user->setNom($params['post']['nom']);
        $user->setPrenom($params['post']['prenom']);
        $user->setEmail($params['post']['email']);
        $user->setPassword($params['post']['password']);
        
        $em->flush();
        
            header('Location: start.php?c=user&t=panelusers');
            exit();

    }

    public function deleteUser($params) {
        $id=($params['get']['id']);
        $em=$params['em'];
        $user=$em->find('User',$id);

        $em->remove($user);
        $em->flush();

        header('Location: start.php?c=user&t=panelusers');
    }

    public function admindisplay($params) {
        
        if ($this->isLoggedIn()) {
            $user_id = $_SESSION['user_id'];
            $user_nom = $_SESSION['user_nom'];
            $user_prenom = $_SESSION['user_prenom'];

            echo $this->twig->render('adminbasepage.html', ['user_nom' => $user_nom, 'user_prenom' => $user_prenom]);
            
        } else {
            header('Location: start.php?c=user&t=login');
        }
    }
}
?>
