<?php

namespace App\Event;

use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Mailer\Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\EventListener\MessageListener;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\EventDispatcher\Event;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader;

class FruitsAddedEvent extends Event
{
    const NAME = 'fruits.added';

    private array $addedFruits;

    public function __construct(array $addedFruits)
    {
        $this->addedFruits = $addedFruits;
    }

    public function sendEmail(): void
    {
        $loader = new FilesystemLoader('templates', __DIR__ . '/../../');
        $twig = new TwigEnvironment($loader);
        $messageListener = new MessageListener(null, new BodyRenderer($twig));

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($messageListener);
        $transport = Transport::fromDsn($_ENV['MAILER_DSN'], $eventDispatcher);

        $mailer = new Mailer($transport, null, $eventDispatcher);

        $email = (new TemplatedEmail())
            ->from(new Address($_ENV['MAILER_FROM']))
            ->to(new Address($_ENV['MAILER_TO']))
            ->priority(TemplatedEmail::PRIORITY_HIGHEST)
            ->subject($_ENV['MAILER_SUBJECT'])
            ->htmlTemplate('email/default.html.twig')
            ->context([
                'fruits' => $this->addedFruits,
            ])
        ;

        $mailer->send($email);

        $this->stopPropagation();
    }
}