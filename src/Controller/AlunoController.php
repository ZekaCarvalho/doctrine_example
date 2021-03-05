<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Aluno;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AlunoController extends AbstractController
{
    /**
     * @Route("/aluno/criar_automaticamente", name="criar_automaticamente")
     */
    public function criarAutomaticamente(): Response
    {
        $alunos = array(
            "Heládio" => "Doce de Leite",
            "Amanda" => "John People",
            "Nadjane" => "Avonlea",
            "Izaquiel" => "Flowers",
            "Flavio" => "Gramado pernambucana",
            "Isaias" => "Terra do pequi",
            "Jameson" => "do mundo"
        );

        foreach ($alunos as $nome => $localidade) {

            $aluno = new Aluno();
            $aluno->setNome($nome);
            $aluno->setLocalidade($localidade);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aluno);
            $entityManager->flush();
        }
        return new Response('Os alunos foram adicionados!');
    }

    /**
     * @Route("/aluno/", name="aluno")
     */
    public function index(): Response
    {
        return $this->render('aluno/index.html.twig', [
            'errors' => '',
        ]);
    }

    /**
     * @Route("/aluno/criar", name="criar_aluno")
     */
    public function criar_aluno(ValidatorInterface $validador, Request $r): Response
    {

        if ($r->isMethod('post')) {
            
            $aluno = new Aluno();
            $aluno->setNome($r->request->get('nome'));
            $aluno->setLocalidade($r->request->get('localidade'));

            $errors = $validador->validate($aluno);

            if (count($errors) > 0) {
                return $this->render('aluno/index.html.twig', [
                    'errors' => $errors,
                ]);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aluno);
            $entityManager->flush();

            $this->addFlash('ok', 'Aluno cadastrado!');

            return $this->redirectToRoute('aluno/index.html.twig');
        }
    }
}
