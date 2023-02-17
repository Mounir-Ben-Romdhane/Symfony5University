<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Club;
use App\Entity\Student;
use App\Form\ClassroomType;
use App\Form\ClubType;
use App\Form\SearchType;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\ClubRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{

    private $classroomRepository;
    private $studentRepository;
    private $clubRepository;


    public function __construct(ClassroomRepository $classroomRepository,
                                 StudentRepository $studentRepository,
                                 ClubRepository $clubRepository)
    {
        $this->classroomRepository = $classroomRepository;
        $this->studentRepository = $studentRepository;
        $this->clubRepository = $clubRepository;
    }

    #[Route('/index', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/showClassrooms', name: 'app_show_classroom')]
    public function list()
    {
        $classrooms=$this->classroomRepository->findAll();
        return $this->render('classroom/index.html.twig', [
            "classrooms" => $classrooms,
        ]);
    }

    

/**
 * @Route("/addClassroom" , name = "add_classroom")
 */
public function addClassroom(Request $request)
{
    $classroom = new Classroom();

    $form = $this->createForm(ClassroomType::class , $classroom);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){

        $classroom = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($classroom);
        $entityManager->flush();
        
        $this->addFlash(
            'Success',
            'Classroom added successfully!'
        );

        return $this->redirectToRoute('app_show_classroom');

    }

    return $this->render('add.html.twig', [
        'classroom' => $form->createView(),
    ]);
}

        
    /**
     * @Route("/edit/{id}" , name = "edit_classroom")
     */
    public function editClassroom(Classroom $classroom , Request $request)
    {
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $classroom = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classroom);
            $entityManager->flush();

            $this->addFlash(
                'Success',
                'Classroom edited successfully!'
            );

            return $this->redirectToRoute('app_show_classroom');

        }

        return $this->render('edit.html.twig', [
            'classroom' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/delete/{id}" , name = "delete_classroom")
     */
    public function deleteClassroom(Classroom $classroom)
        {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classroom);
            $entityManager->flush();

            $this->addFlash(
                'Success',
                'Classroom removed successfully!'
            );

            return $this->redirectToRoute('app_show_classroom');

        }

    #[Route('/showStudents', name: 'app_show_student')]
    public function listStudents()
    {
        $students=$this->studentRepository->findAll();
        return $this->render('listStudent.html.twig', [
            "students" => $students,
        ]);
    }

    #[Route('/trierStudents', name: 'app_trier_student')]
    public function trierStudents(StudentRepository $studentRepository1)
    {
        $students=$studentRepository1->trierStudentByEmailDQL();
        $form=$this->createForm(SearchType::class);
        return $this->render('listStudent.html.twig', [
            "students" => $students,
        ]);
    }

    #[Route('/searchStudent', name: 'search_student')]
    public function searchStudent(StudentRepository $studentRepository1,Request $request)
    {
        $form=$this->createForm(SearchType::class);
        $form->handleRequest($request);
        $students=$this->studentRepository->findAll();
        if($form->isSubmitted() && $form->isValid()){
            $students=$studentRepository1->showAllStudent($form['email']->getData());
            return $this->render('listStudent.html.twig', [
                "students" => $students,
            ]);
        }
        return $this->render('search.html.twig', [
            "studentsf" => $form->createView(),
            "students" => $students,
        ]);
        
    }

    #[Route('/searchStudentByClass', name: 'search_student_class')]
    public function searchStudentByClass(StudentRepository $studentRepository1,Request $request)
    {
        $form=$this->createForm(SearchType::class);
        $form->handleRequest($request);
        $students=$this->studentRepository->findAll();
        if($form->isSubmitted() && $form->isValid()){
            $students=$studentRepository1->showAllStudentByClass($form['classroom']->getData());
            return $this->render('listStudent.html.twig', [
                "students" => $students,
            ]);
        }
        return $this->render('search.html.twig', [
            "studentsf" => $form->createView(),
            "students" => $students,
        ]);
        
    }

    #[Route('/last3Student', name: 'app_last_student')]
    public function lastStudents(StudentRepository $studentRepository1)
    {
        $students=$studentRepository1->showLastStudent();
        return $this->render('listStudent.html.twig', [
            "students" => $students,
        ]);
    }

    #[Route('/searchBetweenStudent', name: 'app_search_student')]
    public function searchStudents(StudentRepository $studentRepository1)
    {
        $students=$studentRepository1->searchBetweenStudent();
        return $this->render('listStudent.html.twig', [
            "students" => $students,
        ]);
    }

    #[Route('/calculeMoyenne', name: 'app_moyenne_student')]
    public function calculeMoyenne(StudentRepository $studentRepository1,Request $request)
    {
        $form=$this->createForm(SearchType::class);
        $form->handleRequest($request);
        $moyenne=$studentRepository1->calculeMoyenne($form['classroom']->getData());
        return $this->render('moyenne.html.twig', [
            "idC" => $form->createView(),
            "idClass"=> $form['classroom']->getData(),
            "moyenne" => $moyenne,
        ]);
    }


    /**
     * @Route("/addStudent" , name = "add_student")
     */
    public function addStudent(Request $request)
    {
        $student = new Student();
        

        $form = $this->createForm(StudentType::class , $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $student = $form->getData(); 
            
            $student->setCreationDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();
            
            $this->addFlash(
                'Success',
                'student added successfully!'
            );

            return $this->redirectToRoute('app_show_student');

        }

        return $this->render('addStudent.html.twig', [
            'student' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editStudent/{id}" , name = "edit_student")
     */
    public function editStudent(Student $student , Request $request)
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $student = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            $this->addFlash(
                'Success',
                'Student edited successfully!'
            );

            return $this->redirectToRoute('app_show_student');

        }

        return $this->render('editStudent.html.twig', [
            'student' => $form->createView(),
        ]);
    }


     /**
     * @Route("/deleteStudent/{id}" , name = "delete_student")
     */
    public function deleteStudent(Student $student)
        {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();

            $this->addFlash(
                'Success',
                'Student removed successfully!'
            );

            return $this->redirectToRoute('app_show_student');

        }


        #[Route('/showClubs', name: 'app_show_club')]
    public function listClubs()
    {
        $clubs=$this->clubRepository->findAll();
        return $this->render('listClub.html.twig', [
            "clubs" => $clubs,
        ]);
    }


    /**
     * @Route("/addClub" , name = "add_club")
     */
    public function addclub(Request $request)
    {
        $club = new Club();

        $form = $this->createForm(ClubType::class , $club);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $club = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($club);
            $entityManager->flush();
            
            $this->addFlash(
                'Success',
                'Club added successfully!'
            );

            return $this->redirectToRoute('app_show_club');

        }

        return $this->render('addClub.html.twig', [
            'club' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editClub/{id}" , name = "edit_club")
     */
    public function editClub(Club $club , Request $request)
    {
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $club = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($club);
            $entityManager->flush();

            $this->addFlash(
                'Success',
                'Club edited successfully!'
            );

            return $this->redirectToRoute('app_show_club');

        }

        return $this->render('editClub.html.twig', [
            'club' => $form->createView(),
        ]);
    }


     /**
     * @Route("/deleteClub/{id}" , name = "delete_club")
     */
    public function deleteClub(Club $club)
        {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($club);
            $entityManager->flush();

            $this->addFlash(
                'Success',
                'Club removed successfully!'
            );

            return $this->redirectToRoute('app_show_club');

        }


}

