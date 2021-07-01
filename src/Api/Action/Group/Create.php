<?php


namespace App\Api\Action\Group;

use App\Entity\Group;
use App\Service\Group\GroupCreateService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Create
{
    private GroupCreateService $groupCreateService;

    public function __construct(GroupCreateService $groupCreateService)
    {
        $this->groupCreateService = $groupCreateService;
    }

    public function __invoke(Request $request): Group
    {
        try {
            $name = $request->toArray()['name'];
            $owner = $request->toArray()['owner'];
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        return $this->groupCreateService->create($name, $owner);
    }
}