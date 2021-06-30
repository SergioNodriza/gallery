<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\User\UserRegisterService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Register
{
    private UserRegisterService $userRegisterService;

    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
    }

    public function __invoke(Request $request): User
    {
        $requestArray = $request->toArray();

        try {
            $name = $requestArray['name'];
            $email = $requestArray['email'];
            $password = $requestArray['password'];
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        return $this->userRegisterService->create($name, $email, $password);
    }
}