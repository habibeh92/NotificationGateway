<?php

namespace App\Http\Controllers;

use App\Entities\AnonymousUser;
use App\Exceptions\NotificationDriverNotFound;
use App\Exceptions\NotificationSendingFailed;
use App\Http\Requests\NotificationReportRequest;
use App\Http\Requests\NotificationSendRequest;
use App\Interfaces\NotificationRepositoryInterface;
use App\Notifications\DynamicMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class NotificationsController extends Controller
{

    private NotificationRepositoryInterface $notificationRepository;



    /**
     * UserController constructor
     *
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }



    /**
     * send the message by user
     *
     * @param NotificationSendRequest $request
     *
     * @return JsonResponse
     */
    public function send(NotificationSendRequest $request)
    {
        try {
            Notification::send(new AnonymousUser($request->receptor),
                new DynamicMessage($request->message, Auth::user(), $request->driver));
        } catch (NotificationDriverNotFound $exception) {
            return ApiResponse::clientError("driver_not_found");
        } catch (NotificationSendingFailed $exception) {
            return ApiResponse::clientError("notification_sending_failed");
        }

        return ApiResponse::success([
            'message' => 'Message sent.',
        ]);
    }



    /**
     * the report of notifications
     *
     * @param NotificationReportRequest $request
     *
     * @return JsonResponse
     */
    public function report(NotificationReportRequest $request)
    {
        $data = $this->notificationRepository->report($request->receptor, $request->driver);

        return ApiResponse::success($data);
    }
}
