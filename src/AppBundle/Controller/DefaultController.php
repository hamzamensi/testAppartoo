<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Insecte;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Form\Extension\Core\Type\SubmitType ;
class DefaultController extends Controller
{  
    
    /**  
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $Insect = new Insecte ;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $Insect = $this->container->get('security.token_storage')->getToken()->getUser();
    

}
        $friend = "";
        $friends = $Insect->getMyFriends();
        $form = $this->createFormBuilder()
            ->add('username',TextType::class,array('attr' => array('class' => 'form-control','style' =>'width: 50% ;margin-bottom:15px')))
            ->add('submit',SubmitType::class,array('attr' => array('class' => 'form-control btn-success btn','style' =>'width : 50%;margin-bottom:15px')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $username = $form['username']->getData();
            $friend =new Insecte ;
            $friend =  $this->getDoctrine()->getManager()->getRepository('AppBundle:Insecte')->findOneByUsername($username);

            if($friend){
            $Insect->addMyFriend($friend);
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($friend);
            $em->persist($Insect);

            $em->flush();
            }
        }
        

        // replace this example code with whatever you need
        return $this->render('index.html.twig',array(
            'friends' => $friends,
            'form' => $form->createView(),
            'friend' => $friend
        ));



    }
     /**  
     * @Route("/edit", name="editpage")
     */
    public function EditAction(Request $request)
    {
        $Insect = new Insecte ;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $Insect = $this->container->get('security.token_storage')->getToken()->getUser();
    
}
$form = $this->createFormBuilder($Insect)
            ->add('age',TextType::class,array('attr' => array('class' => 'form-control','style' =>'width:50%;margin-bottom:15px')))
            ->add('race',TextType::class,array('attr' => array('class' => 'form-control','style' =>'width:50%;margin-bottom:15px')))
            ->add('famille',TextType::class,array('attr' => array('class' => 'form-control','style' =>'width:50%;margin-bottom:15px')))
            ->add('norriture',TextType::class,array('attr' => array('class' => 'form-control','style' =>'width:50%;margin-bottom:15px')))
            ->add('submit',SubmitType::class,array('attr' => array('class' => 'form-control','style' =>'width:50%;margin-bottom:15px')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $age = $form['age']->getData();
            $famille = $form['famille']->getData();
            $race = $form['race']->getData();
            $norriture = $form['norriture']->getData();
            
            $Insect->setAge($age);
            $Insect->setFamille($famille);
            $Insect->setRace($race);
            $Insect->setNorriture($norriture);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($Insect);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        
        // replace this example code with whatever you need
        return $this->render('edit.html.twig',array(
            'form' => $form->createView()
        ));
    }


    /**  
     * @Route("/delete/{username}", name="removefriend")
     */

         public function RemoveAction(Request $request,$username){
             $Insect = new Insecte ;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $Insect = $this->container->get('security.token_storage')->getToken()->getUser();
    
}else {
    return $this->redirectToRoute('login'); 
}
             $friend =  $this->getDoctrine()->getManager()->getRepository('AppBundle:Insecte')->findOneByUsername($username);

            if($friend){
            $Insect->removeMyFriend($friend);
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($friend);
            $em->persist($Insect);

            $em->flush();
            //return $this->redirectToRoute('homepage'); 
            $friends = $Insect->getMyFriends();
    $amis = array();
    foreach($friends as $friend) {
        $amis[] = array("username" => $friend->getUsername()) ;
    }
    $response = new Response(json_encode($amis));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
            
         }
         }
          /**  
     * @Route("/ajouter/{username}", name="addfriend")
     */

         public function AddFriendAction(Request $request,$username){
             $Insect = new Insecte ;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $Insect = $this->container->get('security.token_storage')->getToken()->getUser();
    
}
             $friend =new Insecte ;
            $friend =  $this->getDoctrine()->getManager()->getRepository('AppBundle:Insecte')->findOneByUsername($username);

            if($friend){
            $Insect->addMyFriend($friend);
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($friend);
            $em->persist($Insect);

            $em->flush();
            $friends = $Insect->getMyFriends();
    $amis = array();
    foreach($friends as $friend) {
        $amis[] = array("username" => $friend->getUsername()) ;
    }
    $response = new Response(json_encode($amis));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
            //return $this->redirectToRoute('homepage'); 

            }
         }

         /**  
     * @Route("/getuser/", name="getuser")
     */

         public function getUserAction(Request $request){
             $Insect = new Insecte ;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $Insect = $this->container->get('security.token_storage')->getToken()->getUser();
    $i =  $this->getDoctrine()->getManager()->getRepository('AppBundle:Insecte')->findOneByUsername($Insect->getUsername());
    $user = array (
        "username" => $i->getUsername(),
        "age" => $i->getAge(),
        "famille" => $i->getFamille(),
        "norriture" => $i->getNorriture(),
        "race" => $i->getRace()
    );
    $response = new Response(json_encode($user));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
    
}else {
    return null ; 
}
             ; 
         }
         

         /**  
     * @Route("/getmyfriends/", name="getfriends")
     */

         public function getFriendsAction(Request $request){
             $Insect = new Insecte ;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $Insect = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $friends = $Insect->getMyFriends();
    $amis = array();
    foreach($friends as $friend) {
        $amis[] = array("username" => $friend->getUsername()) ;
    }
    $response = new Response(json_encode($amis));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
    
}else {
    return null ; 
}
             ; 
         }
            /**  
     * @Route("/allUsers/", name="getUsers")
     */

         public function getUsersAction(Request $request){

                  $Insect = new Insecte ;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $Insect = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $friends = $Insect->getMyFriends();
    $amis = array();
    foreach($friends as $friend) {
        $amis[] = array("username" => $friend->getUsername()) ;
    }
            $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Insecte')->findAll();
            $users = array();
    foreach($em as $user) {
        if($user->getUsername() != $Insect->getUsername()){
        $is_friend = false ;
        foreach($amis as $ami){
            if ($user->getUsername() == $ami["username"]){
                $is_friend=true ;
                break;
            }
        }
        $users[] = array("username" => $user->getUsername(),"is_friend" => $is_friend ) ;
    }
    }
    $response = new Response(json_encode($users));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
         }
         }
}
