<?php

namespace App\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;

class BanListener
{
	protected $em;
	protected $router;

	public function __construct(EntityManagerInterface $em, TokenStorageInterface $sam, RouterInterface $router)
	{
		$this->em= $em;
		$this->sam = $sam;
		$this->router = $router;
	}

	public function onKernelRequest(GetResponseEvent $event)
	{
		$request = $event->getRequest();
		$path = $request->getPathInfo();
		if($path != "/login" && $path != "/banned")
		{
			if($this->sam->getToken() == null) return;
	        $user = $this->sam->getToken()->getUser();
			if ($user->getBanned()) {
				$url = $this->router->generate("banned");
				$response = new RedirectResponse($url);
				$event->setResponse($response);
			}			
		}
	}
}