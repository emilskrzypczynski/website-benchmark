<?php

namespace App\Controller;

use App\BenchmarkService\BenchmarkService;
use App\Event\BenchmarkEvent;
use App\Event\Events;
use App\Form\Model\BenchmarkRequest;
use App\Form\Type\BenchmarkType;
use App\Report\BenchmarkHTMLReportGenerator;
use App\Report\ReportGeneratorFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

class BenchmarkController extends AbstractController
{
    /** @var TranslatorInterface */
    private $translator;

    /** @var BenchmarkService */
    private $benchmarkService;

    /** @var ReportGeneratorFactory */
    private $benchmarkHTMLReportGenerator;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var SessionInterface */
    private $session;


    public function __construct(
        TranslatorInterface $translator,
        BenchmarkService $benchmarkService,
        BenchmarkHTMLReportGenerator $benchmarkHTMLReportGenerator,
        EventDispatcherInterface $eventDispatcher,
        SessionInterface $session
    )
    {
        $this->translator = $translator;
        $this->benchmarkService = $benchmarkService;
        $this->benchmarkHTMLReportGenerator = $benchmarkHTMLReportGenerator;
        $this->eventDispatcher = $eventDispatcher;
        $this->session = $session;
    }

    /**
     * @Route("/", name="benchmark_index")
     */
    public function index(Request $request): Response
    {
        $benchmarkRequest = new BenchmarkRequest();

        $form = $this->createForm(BenchmarkType::class, $benchmarkRequest);

        $form->handleRequest($request);

        $benchmarkHtmlReport = $this->session->get('lastReport');

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $benchmark = $this->benchmarkService->createFromRequest($benchmarkRequest);

                $this->eventDispatcher->dispatch(
                    Events::ON_BENCHMARK_FINISH,
                    new BenchmarkEvent($benchmark)
                );

                $benchmarkHtmlReport = $this->benchmarkHTMLReportGenerator
                    ->create($benchmark)
                    ->getAsHTML();

                $this->addFlash(
                    "success",
                    $this->translator->trans('form.benchmark.submit_success', [], 'messages')
                );

                $this->session->set('lastReport', $benchmarkHtmlReport);

                return $this->redirectToRoute('benchmark_index');

            } else {
                $this->session->remove('lastReport');

                $this->addFlash(
                    "danger",
                    $this->translator->trans('form.global.check_form_errors', [], 'messages')
                );
            }
        }

        return $this->render('benchmark/index.html.twig', [
            'form' => $form->createView(),
            'report' => $benchmarkHtmlReport
        ]);
    }
}
