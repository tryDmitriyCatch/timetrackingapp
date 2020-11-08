<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Service\ExportDataService;
use App\Service\Traits\DemTrait;
use App\Utils\DatesUtils;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiTaskController
 * @package App\Controller
 */
class ApiTaskController extends AbstractController {

    use DemTrait;

    public const EXPORT_TYPE_PDF = 'pdf';
    public const EXPORT_TYPE_CSV = 'csv';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ExportDataService
     */
    private $exportDataService;

    /**
     * WebController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ExportDataService $exportDataService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ExportDataService $exportDataService
    )
    {
        $this->dem = $entityManager;
        $this->exportDataService = $exportDataService;
    }

    /**
     * @Route("/api/fetch_tasks", name="fetch-tasks")
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchUsersTasks(Request $request): JsonResponse
    {
        $userId = $request->get('userId');

        $userRepository = $this->getRepository(User::class);

        /** @var User $userEntity */
        $userEntity = $userRepository->findOneBy(['id' => $userId]);

        if (!$userEntity instanceof User) {
            return $this->buildUserNotFoundResponse();
        }

        $taskRepository = $this->getRepository(Task::class);

        /** @var Task $taskEntity */
        $taskEntity = $taskRepository->findByUserId($userEntity->getId());

        return $this->json([
            'status' => 'success',
            'data'   => $taskEntity
        ]);
    }

    /**
     * @Route("/api/user_add_task", name="api-user-add-task")
     * @param Request $request
     * @return JsonResponse
     */
    public function addTaskAction(Request $request): JsonResponse
    {
        $userId = $request->get('userId');

        $userRepository = $this->getRepository(User::class);

        /** @var User $userEntity */
        $userEntity = $userRepository->findOneBy(['id' => $userId]);

        if (!$userEntity instanceof User) {
            return $this->buildUserNotFoundResponse();
        }

        $task = (new Task())
            ->setTitle($request->get('title'))
            ->setDescription($request->get('description'))
            ->setTimeSpent($request->get('timeSpent'))
            ->setCreatedAt(new DateTimeImmutable('now'))
            ->setUpdatedAt(new DateTimeImmutable('now'))
            ->setUser($userEntity);

        $this->persist($task, true);

        return $this->json([
            'status' => 'success',
            'user'   => $userEntity
        ]);
    }

    /**
     * @Route("/api/export", name="api-export")
     * @param Request $request
     * @return string|JsonResponse|Response
     */
    public function exportAction(Request $request)
    {
        $fileName = 'Export';
        $response = '';
        $fromDate = null;
        $toDate = null;
        $userId = $request->get('userId');

        /** @var User $userEntity */
        $userEntity = $this->getRepository(User::class)->findOneBy(['id' => $userId]);

        if (!$userEntity instanceof User) {
            return $this->buildUserNotFoundResponse();
        }

        if (!empty($request->get('fromDate')) && !empty($request->get('toDate'))) {
            $fromDate = $request->get('fromDate') . ' 00:00';
            $toDate = $request->get('toDate') . ' 23:59';
        }

        $results = $this->getRepository(Task::class)->findByUserIdAndDates($userId, $fromDate, $toDate);

        switch ($request->get('format')) {
            case self::EXPORT_TYPE_CSV:
                $response = $this->exportDataService->exportCSVAction($results);
                $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '_Data.csv"');
                break;
            case self::EXPORT_TYPE_PDF:
                $response = new Response(
                    $this->exportDataService->exportPDF($this->setPDFHtmlTemplate($results)),
                    Response::HTTP_OK,
                    [
                        'Content-type' => 'application/pdf',
                        'Content-Disposition' => "attachment;filename=\"{$fileName}_DATA.pdf\"",
                    ]
                );
                break;
        }

        return $response;
    }


    /**
     * @param array $results
     * @return string
     */
    private function setPDFHtmlTemplate(array $results): string
    {
        $totalMinutes = DatesUtils::getSumOfAllTimeSpent($results);

        return $this->renderView('Templates/PDF.html.twig', [
            'tasks'     => $results,
            'hours'     => DatesUtils::getHours($totalMinutes),
            'minutes'   => DatesUtils::getMinutes($totalMinutes)
        ]);
    }

    /**
     * @return JsonResponse
     */
    private function buildUserNotFoundResponse(): JsonResponse
    {
        return $this->json([
            'status'  => 'error',
            'message' => 'User not found'
        ]);
    }
}
