<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use AppBundle\Service\TaskManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listTasks()
    {
        return $this->render(
            'task/list.html.twig',
            ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findAll()]
        );
    }


    /**
     * @Route("/tasks/create", name="task_create")
     *
     * @param  Request                $request
     * @param  EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createTask(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $task = new Task();

        $taskManager = new TaskManager($manager);
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $taskManager->createTask($task, $user);

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     * @param  Task    $task
     * @param  Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editTask(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser() === $task->getUser()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'La tâche a bien été modifiée.');

                return $this->redirectToRoute('task_list');
            }
            $this->addFlash('error', 'La tâche ne vous appartient pas.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render(
            'task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
            ]
        );
    }


    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     *
     * @param  Task $task
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleTask(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'success',
            sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle())
        );

        return $this->redirectToRoute('task_list');
    }


    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     *
     * @param  Task $task
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteTask(Task $task)
    {
        if (($task->getUser()->getUsername() == "anonym") && ($this->getUser()->getRole() === "ROLE_ADMIN")) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'La tâche anonyme a bien été supprimée.');

            return $this->redirectToRoute('task_list');
        }
        if ($this->getUser() === $task->getUser()) { //check if logged user is the owner of the task
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');

            return $this->redirectToRoute('task_list');
        }
        $this->addFlash('error', 'La tâche ne vous appartient pas.');

        return $this->redirectToRoute('task_list');
    }


}
