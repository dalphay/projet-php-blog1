<?php

use Slim\Http\Request;
use Slim\Http\Response;
use simplon\entities\User;
use simplon\dao\DaoUser;
use simplon\entities\Articles;
use simplon\dao\DaoArticles;



// Routes


$app->get('/', function (Request $request, Response $response, array $args) {
    $user = $_SESSION['user'];

    //On instancie le dao
    $dao = new DaoUser();
    //On récupère les users via la méthode getAll
    $users = $dao->getAll();
    //On passe les users à la vue index.twig
    return $this->view->render($response, 'index.twig', [
        'users' => $users
    ]);
})->setName('index');

$app->get('/blog/{id}', function (Request $request, Response $response, array $args) {
    $user = $_SESSION['user'];

    $dao = new DaoUser();
    $dao2 = new DaoArticles(); 
    $articles = $dao2->getByUser($args['id']);

    return $this->view->render($response, 'blog.twig', [
        'articles' => $articles
    ]);
})->setName('blog');

$app->get('/adduser', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'inscription.twig');
})->setName('adduser');



$app->post('/adduser', function (Request $request, Response $response, array $args) {
    //On récupère les données du formulaire
    $form = $request->getParsedBody();
    //On crée une Person à partir de ces données
    $newuser = new User($form['name'], $form['email'], $form['password']);
    //On instancie le DAO
    $dao = new DaoUser();
    //On utilise la méthode add du DAO en lui donnant le user qu'on vient de créer
    $dao->add($newuser);
    //On affiche la même vue que la route en get
    return $this->view->render($user, 'adduser.twig', [
        'newId' => $newUser->getId()
    ]);
})->setName('adduser');

$app->get('/updateuser/{id}', function (Request $request, Response $response, array $args) {
    //On instancie le DAO
    $dao = new DaoUser;
    //On récupère la Person à partir de l'id
    $user = $dao->getById($args['id']);
    // On affiche la vue du formulaire d'update d'une peronne
    return $this->view->render($response, 'updateuser.twig', [
        'user' => $user
    ]);
    
})->setName('updateuser');

$app->post('/updateuser/{id}', function (Request $request, Response $response, array $args) {
    //On instancie le DAO
    $dao = new DaoUser;
    //On récupère les données du formulaire
    $postData = $request->getParsedBody();
    //On récupère la Person à partir de l'id
    $user = $dao->getById($args['id']);
    //On met à jour son nom, sa date de naissance et son genre
    $person->setName($postData['name']);
    $person->setEmail($postData['email']);
    $person->setPassword($postData['password']);
    //On update la personne
    $dao->update($person);
    //On récupère l'URL da la route index (page d'accueil)
    $redirectUrl = $this->router->pathFor('index');
    //On redirige l'utilisateur sur la page d'accueil
    return $response->withRedirect($redirectUrl);
})->setName('updateser');

$app->get('/deleteuser/{id}', function (Request $request, Response $response, array $args) {
    //On instancie le DAO
    $dao = new DaoPerson;
    //On delete le user
    $dao->delete($args['id']);
    //On récupère l'URL da la route index (page d'accueil)
    $redirectUrl = $this->router->pathFor('index');
    //On redirige l'utilisateur sur la page d'accueil
    return $response->withRedirect($redirectUrl);
})->setName('deleteuser');


//séparation...!



$app->get('/articles', function (Request $request, Response $response, array $args) {
    $dao = new DaoArtciles();
    $articles = $dao->getAll();

    return $this->view->render($response, 'index.twig', [
        'articles' => $articles
    ]);
})->setName('index');

$app->get('/addarticles', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'addarticles.twig');
})->setName('addarticles');



$app->post('/addarticles', function (Request $request, Response $response, array $args) {
    $form = $request->getParsedBody();

    $newarticles = new Articles($form['date'], new $form['titre'], $form['contenu']);
    $dao = new DaoUser();

    $dao->add($newuser);
    return $this->view->render($user, 'addarticles.twig', [
        'newId' => $newUser->getId()
    ]);
})->setName('addarticles');

$app->get('/updatearticles/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoArtciles;

    $arctiles = $dao->getById($args['id']);
    return $this->view->render($response, 'updateuser.twig', [
        'articles' => $articles
    ]);
    
})->setName('updatearticles');

$app->post('/updatearticles/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoUser;

    $postData = $request->getParsedBody();
    $user = $dao->getById($args['id']);

    $person->setName($postData['date']);
    $person->setEmail($postData['titre']);

    $person->setPassword($postData['contenu']);
    $dao->update($person);

    $redirectUrl = $this->router->pathFor('index');
    return $response->withRedirect($redirectUrl);
})->setName('updatesarticles');

$app->get('/deletearticles/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoArtciles;
    $dao->delete($args['id']);
    $redirectUrl = $this->router->pathFor('index');

    return $response->withRedirect($redirectUrl);
})->setName('deletearticles');


$app->post('/login', function (Request $request, Response $response, array $args) {
    $dao = new DaoUser;
    $postData = $request->getParsedBody();
    $user = $dao->getByEmail($postData['email']);
    if(!empty($user) && $postData['password'] === $user->getPassword()){
        $_SESSION['user']=$user;
        $redirectUrl = $this->router->pathFor('blog', ['id'=> $user->getId()]);
        
        return $response->withRedirect($redirectUrl);
        

        return $response->withRedirect('blog');

    }

    return $this->view->render($response, 'inscription.twig');


    

   
})->setName('login');









