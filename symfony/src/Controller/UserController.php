<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserUpdate;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;


class UserController extends AbstractController
{

    #[Route('/api/users', name: 'user_display', methods: ['GET'])]
    public function displayUser(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $user = $userRepository->find($this->getUser()->getId());

        if ($user) {
            $jsonUser = $serializer->serialize($user, 'json');
            return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
        }
        return new JsonResponse('User not authentified', Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/users/{id}', name: 'user_get', methods: ['GET'])]
    public function getUserById(UserRepository $userRepository, SerializerInterface $serializer, $id): JsonResponse
    {
        $user = $userRepository->find($id);

        if ($user) {
            $jsonUser = $serializer->serialize($user, 'json');
            return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
        }
        return new JsonResponse('User not found', Response::HTTP_NOT_FOUND);
    }


    #[Route('/api/users', name: 'user_update', methods: ['PUT'])]
    public function updateUser(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, TokenStorageInterface $tokenStorage): JsonResponse
    {
        $token = $tokenStorage->getToken();

        // Vérifier si le token est valide
        if ($token instanceof TokenInterface) {
            // Récupérer l'utilisateur associé au token
            $user = $token->getUser();
            $data = json_decode($request->getContent(), true);
            $user->setLogin($data['login'] ?? $user->getLogin());
            $user->setEmail($data['email'] ?? $user->getEmail());
            $user->setFirstname($data['firstname'] ?? $user->getFirstname());
            $user->setLastname($data['lastname'] ?? $user->getLastname());

            $entityManager->flush();

            $jsonProject = $serializer->serialize($user, 'json', ['groups' => ['conference:list', 'conference:item']]);
            return new JsonResponse($jsonProject, Response::HTTP_OK, [], true);
        }
        return new JsonResponse("User not connected", Response::HTTP_OK);
    }

    #[Route('api/users/update_form', name: 'update_user_form', methods: 'POST')]
    public function updateUserForm(Request $request, UserRepository $userRepository, EntityManagerInterface $em, SerializerInterface $serializer, TokenStorageInterface $tokenStorage): JsonResponse
    {
        $token = $tokenStorage->getToken();

        if ($token instanceof TokenInterface) {
            /** @var User $user */
            $user = $token->getUser();
            $data = json_decode($request->getContent(), true);
            $user->setBirthday($data['birthdate'] ?? $user->getBirthday());
            $user->setCountry($data['country'] ?? $user->getCountry());
            $user->setRoad($data['address'] ?? $user->getRoad());
            $user->setCity($data['city'] ?? $user->getCity());
            $user->setPostalCode($data['postal'] ?? $user->getPostalCode());
            $user->setMobilePhone($data['tel'] ?? $user->getMobilePhone());
            $user->setSkills($data['skills'] ?? $user->getSkills());
            $user->setBiography($data['biography'] ?? $user->getBiography());
            $user->setPath($data['path'] ?? $user->getPath());
            $user->setInterest($data['interest'] ?? $user->getInterest());
            foreach ($data['links'] as $link) {
                switch ($link[0]):
                    case "linkedin":
                        $user->setLinkedin($link[1] ?? $user->getLinkedin());
                        break;
                    case "github":
                        $user->setGithub($link[1] ?? $user->getGithub());
                        break;
                    default:
                        break;
                endswitch;
            }

            $em->flush();

            return new JsonResponse("User updated successfully", Response::HTTP_OK);
        }
        return new JsonResponse("User not connected", Response::HTTP_OK);
    }


}