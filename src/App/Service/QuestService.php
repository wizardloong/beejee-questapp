<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Quest;
use Doctrine\ORM\EntityManagerInterface;
use jblond\xss_filter;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class QuestService
{
    private $e;
    private $xssFilter;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, xss_filter $xssFilter, Validator $validator)
    {
        $this->e = $entityManager;
        $this->xssFilter = $xssFilter;
        $this->validator = $validator;
    }

    public function addNew(array $params)
    {
        $params = $this->filter($params);

        $validator = $this->validate($params);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $quest = new Quest(
            $params['username'],
            $params['email'],
            $params['description']
        );

        $this->e->persist($quest);
        $this->e->flush();

        return [];
    }

    public function update(Quest $quest, array $params)
    {
        $params = $this->filter($params);

        $validator = $this->validate($params);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        if ($quest->getUsername()    !== $params['username']    ||
            $quest->getEmail()       !== $params['email']       ||
            $quest->getDescription() !== $params['description']
        ) {
            $quest->setEditedByAdmin();

            $quest->setUsername($params['username']);
            $quest->setEmail($params['email']);
            $quest->setDescription($params['description']);
        }

        $quest->setCompleted($params['completed'] === 'true');

        $this->e->persist($quest);
        $this->e->flush();

        return [];
    }

    private function validate(array $params) : Validation
    {
        return $this->validator->validate($params, [
            'username' => 'required',
            'email' => 'required|email',
            'description' => 'required'
        ]);
    }

    private function filter(array $params) : array
    {
        $filteredParams = [];
        foreach ($params as $key => $value) {
            $filteredParams[$key] = $this->xssFilter->filter_it($value);
        }

        return $filteredParams;
    }
}
