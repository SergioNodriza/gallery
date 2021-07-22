<?php


namespace App\Api\Action\Group;

use App\Entity\Group;
use App\Service\Group\GroupCreateService;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Create
{
    private GroupCreateService $groupCreateService;
    private TokenExtractorInterface $tokenExtractor;

    public function __construct(GroupCreateService $groupCreateService, TokenExtractorInterface $tokenExtractor)
    {
        $this->groupCreateService = $groupCreateService;
        $this->tokenExtractor = $tokenExtractor;
    }

    public function __invoke(Request $request): Group
    {
        try {
            $name = $request->toArray()['name'];
            $token = $this->tokenExtractor->extract($request);
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        return $this->groupCreateService->create($name, $token);
    }
}