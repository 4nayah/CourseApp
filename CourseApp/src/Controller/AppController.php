<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Uid\Ulid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{

    public $CurrentUser;
    

   
    public function IsAuth()
    {
        //$apiToken = $request->headers->get('Token');
        // if($apiToken !=null){
        //     return true;
        // }
        //return false;
    }
    
    /**
     * @Route("/Connect", name="Connect" , methods={"POST"})
     */
    public function Connect(Request $request, EntityManagerInterface $em ,SerializerInterface $serializer)
    {
        
        
        $data = json_decode($request->getContent(), true);
        $email = $data['Email'];
        $pass = $data['Password'];

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['Email'=>$email,'Password' =>$pass]);
        if($user == null){
            return $this->json(['message'=>'impossible de se connecter']);
        }
        $user->setPassword("*******");
        $user->setHashKey("*******");
        $CurrentUser = $user;
        return $this->json(['user'=>$user,'token'=>strrev(new Ulid())]);
        
        
    }

    
}
