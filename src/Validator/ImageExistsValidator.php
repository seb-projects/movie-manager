<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ImageExistsValidator extends ConstraintValidator
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            $this->context->buildViolation($constraint->message)->addViolation();

            return;
        }

        $response = $this->httpClient->request('GET', $value);

        if (200 !== $response->getStatusCode()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
