<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class ProjectController extends AbstractController
{
    #[Route('/api/projects', name: 'allProjects', methods: ['GET'])]
    public function getProjects(ProjectRepository $projectRepository, SerializerInterface $serializer): JsonResponse
    {
        $projectsList = $projectRepository->findAll();
        $jsonProjectsList = $serializer->serialize($projectsList, 'json');
        return new JsonResponse($jsonProjectsList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/projects/{id}', name: 'projectDetails', methods: ['GET'])]
    public function getDetailProject(int $id, SerializerInterface $serializer, ProjectRepository $projectRepository): JsonResponse
    {
        $project = $projectRepository->find($id);
        if ($project) {
            $jsonProject = $serializer->serialize($project, 'json');
            return new JsonResponse($jsonProject, Response::HTTP_OK, [], true);
        }
        return new JsonResponse('Project not found', Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/projects/{id}', name: 'projectDelete', methods: ['DELETE'])]
    public function deleteProject(Project $project, EntityManagerInterface $em, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker): JsonResponse
    {
        try {
            // Supprimer le projet
            $em->remove($project);
            $em->flush();

            return new JsonResponse('Project deleted successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse('Failed to delete project', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/api/projects', name: "ProjectCreate", methods: ['POST'])]
    public function createProject(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserRepository $userRepository): JsonResponse
    {
        
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        
        $project = $serializer->deserialize($request->getContent(), Project::class, 'json');

        if ($project) {
            $project->setOwner($user->getId());
            $em->persist($project);
            $em->flush();

            $jsonProject = $serializer->serialize($project, 'json');

            return new JsonResponse($jsonProject, Response::HTTP_CREATED, [], true);
        } else {
            return new JsonResponse('Can\'t create project', Response::HTTP_CREATED, [], true);
        }
    }

    #[Route('/api/projects/{id}/join', name: "ProjectJoin", methods: ['PUT'])]
    public function joinProject(Request $request, SerializerInterface $serializer, Project $currentProject, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        $updatedProject = $serializer->deserialize($request->getContent(),
            Project::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentProject]);


        if (!$currentProject) {
            return new JsonResponse('Project not found', Response::HTTP_NOT_FOUND);
        }
        
        $participants = $updatedProject->getParticipants();
        if(in_array($user->getId(), $participants, true)) {
            return new JsonResponse('User is already a participant of the project', Response::HTTP_BAD_REQUEST);
        }

        $participants[] = $user->getId();
        $updatedProject->setParticipants($participants);

        $em->persist($updatedProject);
        $em->flush();

        return new JsonResponse('User joined the project successfully', Response::HTTP_OK);
    }

    #[Route('/api/projects/{id}/leave', name: "ProjectLeave", methods: ['PUT'])]
    public function leaveProject(Project $currentProject, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        $participants = $currentProject->getParticipants();
        $userId = $user->getId();

        if (!in_array($userId, $participants, true)) {
            return new JsonResponse('User is not a participant of the project', Response::HTTP_BAD_REQUEST);
        }

        $updatedParticipants = array_diff($participants, [$userId]);
        $currentProject->setParticipants($updatedParticipants);

        $em->persist($currentProject);
        $em->flush();

        return new JsonResponse('User left the project successfully', Response::HTTP_OK);
    }


    #[Route('/api/projects/{id}', name: "ProjectUpdate", methods: ['PUT'])]
    public function updateProject(Request $request, SerializerInterface $serializer, Project $currentProject, EntityManagerInterface $em): JsonResponse
    {

        $updatedProject = $serializer->deserialize($request->getContent(),
            Project::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentProject]);

        $em->persist($updatedProject);

        try {
            $em->flush();
            $jsonProject = $serializer->serialize($updatedProject, 'json');
            return new JsonResponse($jsonProject, Response::HTTP_OK, [], true);
        } catch (\Exception $e) {
            return new JsonResponse('Failed to update project', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
