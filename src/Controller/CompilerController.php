<?php

namespace App\Controller;

use App\Compiler\Executor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class CompilerController extends AbstractController
{
    /** KernelInterface $appKernel */
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }
    /**
     * @Route("/compiler", name="compiler")
     */
    public function index(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('language', ChoiceType::class, ['choices' => ['Java' => 'java']])
            ->add('code', TextareaType::class)
            ->add('input', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Run Code'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $obj = new Executor('java');
            //set compilation path
            $obj->setCompilationPath($this->appKernel->getProjectDir() . '/var/compiler');

            //java
            $java_code = <<<'EOT'
	public class Main {
	public static void main(String[] args) {
        // Prints "Hello, World" to the terminal window.
        System.out.println("Hello, Java");
    }
}
EOT;
            $comp = $obj->compile($java_code);

            return new Response( "Compilation : " . ( ! is_array($comp) ? "Success" : "Fail" )  . "\n" .
                "Running is : " . ( ! is_array($comp) ? $obj->run() : "Fail" ) . "\n"
            );

//            return new Response(
//                'Compiler path: '. $obj->getCompilationPath()
//            );
        }
        return $this->render('compiler/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
