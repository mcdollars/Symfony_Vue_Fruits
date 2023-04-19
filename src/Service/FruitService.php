<?php
namespace App\Service;

use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class FruitService
 * @property FruitRepository $fruitRepository
 * @property HttpClientInterface $client
 * @property MailerInterface $mailer
 * @property $fromEmail
 * @property $adminEmail
 * @package AppBundle\Service
 */
class FruitService
{

    /**
     * @param HttpClientInterface $client
     * @param FruitRepository $fruitRepository
     * @param MailerInterface $mailer
     * @param $fromEmail
     * @param $adminEmail
     */
    public function __construct(
        HttpClientInterface $client,
        FruitRepository $fruitRepository,
        MailerInterface $mailer,
        $fromEmail,
        $adminEmail
    ) {
        $this->client = $client;
        $this->fruitRepository = $fruitRepository;
        $this->mailer = $mailer;
        $this->fromEmail = $fromEmail;
        $this->adminEmail = $adminEmail;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $items = $this->fruitRepository->findAll();
        $fruits = [];
        foreach ($items as $item) {
            $fruits[] =  $item->toArray();
        }
        return $fruits;
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function addToFavourites($request): JsonResponse
    {
        $limit = 10;
        $session = $request->getSession();
        $payload = json_decode($request->getContent(), true);
        $fruitId = $payload['fruitId'];
        $name = $payload['name'];
        $favourites = $session->get('favourites') ?? [];
        $message =  $name. ' added to your favourites!';
        $status = 'success';
        if (in_array($fruitId, $favourites)) {
            $message = $name.' already in your favourites';
            $status = 'error';
        } elseif (count($favourites) < $limit && !in_array($fruitId, $favourites)) {
            $session->set('favourites', array_merge($favourites, [$fruitId]));
        } elseif (count($favourites) === $limit) {
            $message = 'You already have '.$limit.' fruits in your favourites';
            $status = 'error';
        }
        return new JsonResponse([
            "favourites" => $favourites,
            "code" => Response::HTTP_OK,
            "status" => $status,
            "message" => $message ?? 'Removed!'
        ], Response::HTTP_OK);
    }
    /**
     * @param $request
     * @return array
     */
    public function getFavourites($request): array
    {
        $ids = $request->getSession()->get('favourites');
        if (!$ids || count($ids) === 0) {
            return [];
        }
        $items = $this->fruitRepository->findByIds($ids);
        $fruits = [];
        foreach ($items as $item) {
            $fruits[] = $item->toArray();
        }
        return $fruits;
    }

    /**
     * @return void
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchAll(): void
    {
        $response = $this->client->request(
            'GET',
            'https://fruityvice.com/api/fruit/all'
        );
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $fruits = $response->toArray();
            foreach ($fruits as $item) {
                $fruit = $this->fruitRepository->findOneBy(['name' => $item['name']]);
                if (!$fruit) {
                    $fruit = new Fruit();
                }
                $fruit->setGenus($item['genus']);
                $fruit->setName($item['name']);
                $fruit->setFamily($item['family']);
                $fruit->setFruitOrder($item['order']);
                if (isset($item['nutritions'])) {
                    $fruit->setNutritions($item['nutritions']);
                    $nutritionSum = 0;
                    foreach ($item['nutritions'] as $nutrition) {
                        $nutritionSum = $nutrition + $nutritionSum;
                    }
                    $fruit->setNutritionSum($nutritionSum);
                }
                $this->fruitRepository->save($fruit);
            }
            if (count($fruits) > 0) {
                $this->fruitRepository->flush();
            }
        }
    }
}
